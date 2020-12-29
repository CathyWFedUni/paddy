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

public class message {
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
		public void testMessage() throws InterruptedException, IOException {
		    
			// load file
			File src=new File("data/message.xlsx"); 
			
			FileInputStream finput = new FileInputStream(src); 
			
			// Load the workbook. 

			workbook = new XSSFWorkbook(finput); 

			// Load the sheet in which data is stored. 

			sheet= workbook.getSheetAt(0); 
			//set userName
			cell = sheet.getRow(1).getCell(0); 
			cell.setCellType(CellType.STRING);  
			String userName = cell.getStringCellValue(); 
			//System.out.println(userName);
		
			//set password
			cell = sheet.getRow(1).getCell(1); 
			cell.setCellType(CellType.STRING);  
			String password = cell.getStringCellValue(); 
			//System.out.println(password);
			
			//login 
		    driver.get("http://localhost/ITECH3208_LanguageClub/loginpage.php");
		    driver.manage().window().setSize(new Dimension(1936, 1056));
		    driver.findElement(By.cssSelector(".whitebox")).click();
		    driver.findElement(By.id("username")).sendKeys(userName);
		    driver.findElement(By.id("password")).sendKeys(password);
		    driver.findElement(By.name("Login")).click();	
			
			for(int i=1;  i<=sheet.getLastRowNum(); i++) { 			
				try	     
				{	
					 driver.findElement(By.linkText("Contact Organiser")).click();
					 driver.findElement(By.name("query_header")).click();
					 {
						 //	use select drop down function			    
					      WebElement testDropDown  = driver.findElement(By.name("query_header"));			    			      
					      Select dropdown  = new Select(testDropDown); 
					      
					     //change language base on value defined in the spreadsheet
					      dropdown.selectByVisibleText("Availability");					      
					 
				      }
					 
					driver.findElement(By.name("query_body")).click();
				    driver.findElement(By.name("query_body")).sendKeys("TESTING");
				    driver.findElement(By.name("goButton")).click();
				    driver.switchTo().alert().accept();	
				    
				    //login as admin to verify message
				    driver.findElement(By.linkText("Log out")).click();
				    driver.findElement(By.id("username")).click();
				    driver.findElement(By.cssSelector(".whitebox")).click();
				    driver.findElement(By.id("username")).sendKeys("CathyAdmin");
				    driver.findElement(By.cssSelector("img")).click();
				    driver.findElement(By.cssSelector(".whitebox")).click();
				    driver.findElement(By.id("password")).sendKeys("CathyAdmin2020");
				    driver.findElement(By.name("Login")).click();
				    driver.findElement(By.linkText("Inbox")).click();
				    
				    //assertion for user name, message title and message
				    assertEquals(driver.findElement(By.cssSelector("tr:nth-child(1) > td:nth-child(2)")).getText(),"CathyMember");				   
				    assertEquals(driver.findElement(By.cssSelector("tr:nth-child(1) > td:nth-child(5)")).getText(), "Availability");
				    assertEquals(driver.findElement(By.cssSelector("tr:nth-child(1) > td:nth-child(6)")).getText(),"TESTING");	
				    
				    System.out.println ("Message sent successfully for " + userName );	
					
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

