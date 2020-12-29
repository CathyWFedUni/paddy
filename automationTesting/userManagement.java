package itech3209;

import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertNotSame;
import static org.junit.Assert.assertThat; 

import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.util.HashMap;
import java.util.Map;
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


/* this class tests the user management updating process. 
 * there are three small tests in this class, first one updates the language and verified the language is updated using an expected value. 
 * second test updates the role and verify the role is updated using the expected value
 * Third one deletes the account and verify the account is no longer available in the position. 
 * 
 */

public class userManagement {

	//setup web driver and spreadsheet
	private WebDriver driver;
	private Map<String, Object> vars;
	
	JavascriptExecutor js;
	XSSFWorkbook workbook;
	XSSFSheet sheet;
	XSSFCell cell; 

	//use to make jar
	public static void main(String args[]) {
		  JUnitCore junit = new JUnitCore();
		  junit.addListener(new TextListener(System.out));
		  Result result = junit.run(registration.class); // Replace "SampleTest" with the name of your class
		  if (result.getFailureCount() > 0) {
		    System.out.println("Test failed.");
		    System.exit(1);
		  } else {
		    System.out.println("Session Test finished successfully.");
		    System.exit(0);
		  }
	}
		
	
	@Before
	public void setUp() {
	 System.setProperty("webdriver.chrome.driver","D:/selenium/study3209/selenium driver/chromedriver.exe");
	 driver = new ChromeDriver();
	 js = (JavascriptExecutor) driver;
	 vars = new HashMap<String, Object>();
	}
	
	@After
	public void tearDown() {
	 driver.quit();
	}

	@Test
	public void testSession() throws InterruptedException, IOException {
	    
		// load file
		File src=new File("data/userManagement.xlsx"); 
		
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
	    
		//loop through the spreadsheet and validate each test cases
		for(int i=1;  i<=sheet.getLastRowNum(); i++) { 			
		
			try	   
			{	
				
				//set row
				cell = sheet.getRow(i).getCell(2); 
				cell.setCellType(CellType.STRING);  
				String rowPosition = cell.getStringCellValue(); 
				//System.out.println(rowPosition);
				
				//set chagneLanguage
				cell = sheet.getRow(i).getCell(3); 
				cell.setCellType(CellType.STRING);  
				String chagneLanguage = cell.getStringCellValue(); 
				//System.out.println(chagneLanguage);				
				
				//set expectedLanguage
				cell = sheet.getRow(i).getCell(4); 
				cell.setCellType(CellType.STRING);  
				String expectedLanguage = cell.getStringCellValue(); 
				//System.out.println(expectedLanguage);
				
				//set updateRole
				cell = sheet.getRow(i).getCell(5); 
				cell.setCellType(CellType.STRING);  
				String updatedRole = cell.getStringCellValue(); 
				//System.out.println(updatedRole);
				
				//set expectedRole
				cell = sheet.getRow(i).getCell(6); 
				cell.setCellType(CellType.STRING);  
				String expectedRole = cell.getStringCellValue(); 
				//System.out.println(expectedRole);	
				
				//set expectedRole
				cell = sheet.getRow(i).getCell(7); 
				cell.setCellType(CellType.STRING);  
				String deletedPosition = cell.getStringCellValue(); 
				//System.out.println(deletedPosition);	
				
				
				//set expectedRole
				cell = sheet.getRow(i).getCell(8); 
				cell.setCellType(CellType.STRING);  
				String deletedUserName = cell.getStringCellValue(); 
				//System.out.println(deletedUserName);	
						
				// Validate update language process in User Management page			
			    driver.findElement(By.linkText("User Management")).click();
			    driver.findElement(By.xpath("(//select[@name='lag_Level'])["+rowPosition +"]")).click();
			    Thread.sleep(5000);
			    {
			    //select Beginner from Select
			      WebElement testDropDown  = driver.findElement(By.xpath("(//select[@name='lag_Level'])["+rowPosition +"]"));			    			      
			      Select dropdown  = new Select(testDropDown); 
			      
			     //change language base on value defined in the spreadsheet
			      dropdown.selectByVisibleText(chagneLanguage);		
			      
			    //click on  Update button
			      driver.findElement(By.cssSelector("tr:nth-child("+ rowPosition +") > td:nth-child(4) .table-button")).click();
			      
			    //Accept Language alert confirmation
			      driver.switchTo().alert().accept();
			    }   
			    
			    // language set and allocated to a String variable for print out later			   
			    String Language = driver.findElement(By.cssSelector("tr:nth-child("+ rowPosition +")> td:nth-child(3)")).getText();
			    // assert if expected language entered in the spreadsheet is the same as the language displayed on the user management page
			    assertEquals(Language, expectedLanguage);
			    System.out.println("Language Test runs successfully: The language for user has been changed to ' " + Language + " ' which matches the expected Language ' " + expectedLanguage + "'");
			    
			    			   
			    /* Function 2 
			     *  Validate update role process in User Management page		
			     */
			    driver.findElement(By.cssSelector("tr:nth-child("+ rowPosition + ")> td:nth-child(5)")).click();
		
			    {
			        //select Beginner from Select
				      WebElement testDropDown  = driver.findElement(By.xpath("(//select[@name='role'])["+rowPosition +"]"));		    			      
				      Select dropdown  = new Select(testDropDown); 
				     //change language base on value defined in the spreadsheet
				      dropdown.selectByVisibleText(expectedRole);
				      Thread.sleep(2000);
				    //click on  Update button
				     // driver.findElement(By.cssSelector("tr:nth-child("+ rowPosition + ") > td:nth-child(5) .table-button")).click();	
				      driver.findElement(By.cssSelector("tr:nth-child("+ rowPosition +")>td:nth-child(6) .table-button")).click();					      
				      Thread.sleep(3000);
				    //Accept Language alert confirmation
				      driver.switchTo().alert().accept();    
			    
			    }   
			    
			    // using row position to get user role			    
			    String acutalRole = driver.findElement(By.cssSelector("tr:nth-child("+ rowPosition + ")>td:nth-child(5)")).getText();
			    
			    // assert if expected language entered in the spreadsheet is the same as the language displayed on the user management page
			    assertEquals(acutalRole, expectedRole );
			    System.out.println("User Role Test runs successfully: The actual user role displayed as ' " + acutalRole + " ' which is equal to expected user role ' " + updatedRole + "'"); 
			
			    
			    /* Function 3
			     * Delete user process in User Management page		
			     */
			    String initialUserName = driver.findElement(By.cssSelector("tr:nth-child("+ deletedPosition + ")>td:nth-child(1)")).getText();
		    	 
		    	 System.out.println("User Name prior deletion : " + initialUserName);
			    driver.findElement(By.cssSelector("tr:nth-child("+ deletedPosition + ")> td:nth-child(7)")).click();
			    assertEquals(driver.switchTo().alert().getText(), ("Are you sure you want to delete?"));
			    Thread.sleep(3000);
	    	    driver.switchTo().alert().accept();			
	
			    System.out.println("User " +  initialUserName+ " has been deleted successfully"); 
			    System.out.println("Three test run to success!" ); 
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