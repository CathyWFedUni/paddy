package itech3209;

import static org.junit.Assert.assertEquals;

import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.util.NoSuchElementException;

import org.apache.poi.ss.usermodel.CellType;
import org.apache.poi.xssf.usermodel.XSSFCell;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import org.junit.internal.TextListener;
import org.junit.runner.JUnitCore;
import org.junit.runner.Result;
import org.openqa.selenium.By;
import org.openqa.selenium.Dimension;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.StaleElementReferenceException;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebDriverException;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.support.ui.Select;

public class editProfile {
	  private WebDriver driver;	  
	  JavascriptExecutor js;
	  XSSFWorkbook workbook;
	  XSSFSheet sheet;
	  XSSFCell cell; 
	  
	  public static void main(String args[]) {
		  JUnitCore junit = new JUnitCore();
		  junit.addListener(new TextListener(System.out));
		  Result result = junit.run(login.class); // Replace "SampleTest" with the name of your class
		  if (result.getFailureCount() > 0) {
		    System.out.println("Test failed.");
		    System.exit(1);
		  } else {
		    System.out.println("Test finished successfully.");
		    System.exit(0);
		  }
	}
	  
	  @Before
	  public void setUp() {	 
		System.setProperty("webdriver.chrome.driver","D:/selenium/study3209/selenium driver/chromedriver.exe");
	    driver = new ChromeDriver();
	    js = (JavascriptExecutor) driver;
	  }
	  
	  @After
	  public void tearDown() {
	    driver.quit();
	  }
	  @Test
	  public void login_Test() throws InterruptedException, IOException {
		  
		// load file
			File src=new File("data/updateUser.xlsx"); 
			
			FileInputStream finput = new FileInputStream(src); 
			
			// Load the workbook. 

			workbook = new XSSFWorkbook(finput); 

			// Load the sheet in which data is stored. 

			sheet= workbook.getSheetAt(0); 
			
			for(int i=1;  i<=sheet.getLastRowNum(); i++) { 			
				try	     
				{	
								
					//set userName
					cell = sheet.getRow(i).getCell(0); 
					cell.setCellType(CellType.STRING);  
					String userName = cell.getStringCellValue(); 
					//System.out.println(userName);
				
					//set current password
					cell = sheet.getRow(i).getCell(1); 
					cell.setCellType(CellType.STRING);  
					String password = cell.getStringCellValue(); 
					//System.out.println(password);
					
					//set new password
					cell = sheet.getRow(i).getCell(2); 
					cell.setCellType(CellType.STRING);  
					String newPassword = cell.getStringCellValue(); 
					//System.out.println(password);
					
					//set new email
					cell = sheet.getRow(i).getCell(3); 
					cell.setCellType(CellType.STRING);  
					String newEmail = cell.getStringCellValue(); 
					//System.out.println(newEmail);
					
					//set new Language level
					cell = sheet.getRow(i).getCell(4); 
					cell.setCellType(CellType.STRING);  
					String newLagLevel = cell.getStringCellValue(); 
					//System.out.println(newLagLevel);
					
					//set non-primary Language position
					cell = sheet.getRow(i).getCell(5); 
					cell.setCellType(CellType.STRING);  
					String lagPosition = cell.getStringCellValue(); 
					//System.out.println(lagPosition);
					
					//set new expectedLagSkill
					cell = sheet.getRow(i).getCell(6); 
					cell.setCellType(CellType.STRING);  
					String expectedLagSkill = cell.getStringCellValue(); 
					//System.out.println(expectedLagSkill);
					
					//set new updatedBio
					cell = sheet.getRow(i).getCell(7); 
					cell.setCellType(CellType.STRING);  
					String updatedBio = cell.getStringCellValue(); 
					//System.out.println(updatedBio);
					
				    driver.get("http://localhost/ITECH3208_LanguageClub/loginpage.php");
				    driver.manage().window().setSize(new Dimension(1936, 1056));				  
				    driver.findElement(By.id("username")).sendKeys(userName);
				    driver.findElement(By.id("password")).sendKeys(password);
				    driver.findElement(By.name("Login")).click();
				    
				    //assert the user login name matches user name in the database
				    String name = driver.findElement(By.cssSelector(".nav_sub_heading:nth-child(3)")).getText();				   
				    assertEquals(name, userName);
				    
				    //change password 
				    driver.findElement(By.linkText("User Account")).click();
				    driver.findElement(By.name("EditAccount")).click();
				    driver.findElement(By.id("changePasswordField")).click();
				    driver.findElement(By.id("changePasswordField")).sendKeys(password);
				    Thread.sleep(2000);
				    driver.findElement(By.name("newPassword")).click();
				    driver.findElement(By.name("newPassword")).sendKeys(newPassword);
				    Thread.sleep(2000);
				    driver.findElement(By.cssSelector(".edit_account-btn:nth-child(6)")).click();
				    driver.findElement(By.linkText("Log out")).click();
				    
				    
				    //log back in using new password				    
				    driver.get("http://localhost/ITECH3208_LanguageClub/loginpage.php");
				    driver.manage().window().setSize(new Dimension(1936, 1056));
				    driver.findElement(By.cssSelector(".whitebox")).click();
				    driver.findElement(By.id("username")).sendKeys(userName);
				    driver.findElement(By.id("password")).sendKeys(newPassword);
				    driver.findElement(By.name("Login")).click();
				    
				    
				    assertEquals(driver.findElement(By.linkText("Log out")).getText(), "Log out");
				    System.out.println ("log out button found, password updated successfully for: " + name);	    
				    		    
	    				    
				    //Test change Email				    
				    driver.findElement(By.linkText("User Account")).click();
				    driver.findElement(By.name("EditAccount")).click();
				    driver.findElement(By.id("email")).click();
				    driver.findElement(By.id("email")).sendKeys(newEmail);				
				    driver.findElement(By.xpath("//input[@name=\'submit\']")).click();
				    //driver.switchTo().alert().accept();	
				    driver.findElement(By.linkText("User Account")).click();				 
				    driver.findElement(By.cssSelector(".userinfo > h1:nth-child(3)")).click();				
				    assertEquals(driver.findElement(By.cssSelector(".userinfo > h1:nth-child(3)")).getText(), newEmail); 				
				    System.out.println ("Email successfully updated~ for " + userName + ":" + newEmail);		    
				    				    
				    //Test change language level				    
				    driver.findElement(By.linkText("User Account")).click();
				    driver.findElement(By.name("EditAccount")).click();
				    driver.findElement(By.name("lag_Level")).click();
				    {
				     //	use select drop down function			    
				      WebElement testDropDown  = driver.findElement(By.name("lag_Level"));			    			      
				      Select dropdown  = new Select(testDropDown); 
				      
				     //change language base on value defined in the spreadsheet
				      dropdown.selectByVisibleText(newLagLevel);		
				      
				    }
				    
				    driver.findElement(By.xpath("//input[@name='submit']")).click();
				    //driver.switchTo().alert().accept();	
				    driver.findElement(By.linkText("User Account")).click();	
				    String actualSkill = driver.findElement(By.cssSelector(".childcard:nth-child("+lagPosition+") > .cardheading")).getText(); 
				    System.out.println(actualSkill); 
				   		
				    assertEquals(driver.findElement(By.cssSelector(".rightColumn>.childcard:nth-child("+lagPosition+") > .cardheading")).getText(), expectedLagSkill); 	
				    
				    System.out.println ("Language successfully updated for " + userName + " -- " + expectedLagSkill);
				    
				    
				    //Test update Bio			    
				    driver.findElement(By.linkText("User Account")).click();
				    driver.findElement(By.name("EditAccount")).click();
				    driver.findElement(By.name("user_custom_description")).click();
				    driver.findElement(By.name("user_custom_description")).sendKeys(updatedBio);				    
				    driver.findElement(By.xpath("//input[@name='submitBio']")).click();
				    //driver.switchTo().alert().accept();	
				    
				    driver.findElement(By.linkText("User Account")).click();
				   		
				    assertEquals(driver.findElement(By.cssSelector("p")).getText(), updatedBio); 	
				    
				    System.out.println ("User Bio updated for " + userName + ": " + updatedBio);	
				    
				    System.out.println ("Tests for Edit Profile page run successfully!");		
				    
				    
				}
				catch (NoSuchElementException ne)
		        {     	
				     ne.printStackTrace();
		        }
					
			    catch(StaleElementReferenceException se) 
		        {					
					 se.printStackTrace();
				}		
				catch (WebDriverException e) 
				{
					 e.printStackTrace();
					
				}
				catch (Throwable t)
			    {
			       t.printStackTrace();
			    }
			} 
			
		  }
	}
