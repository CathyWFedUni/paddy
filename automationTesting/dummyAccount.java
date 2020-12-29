package itech3209;

import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertTrue;

import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.text.SimpleDateFormat;
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

/* This class tests dummy account creation function, including creating session and then creating
 * dummy accounts in the session and adding same name to the dummy account process. 
 * It creates a session that has the latest date time so the session position is always in 2 (first item). 
 * For session creation process, the system validates against the session name and date time entered. 
 * For dummy account creation process, the test checks that participant number increases once an dummy account is created. 
 * For dummy account naming process, the test checks system can append a unique number at the end of the name if same dummy name is added
 * to the session. 
 * 
 */
public class dummyAccount {

	  private WebDriver driver;	  
	  JavascriptExecutor js;
	  XSSFWorkbook workbook;
	  XSSFSheet sheet;
	  XSSFCell cell; 
	  
	  public static void main(String args[]) {
		  JUnitCore junit = new JUnitCore();
		  junit.addListener(new TextListener(System.out));
		  Result result = junit.run(dummyAccount.class); // Replace "SampleTest" with the name of your class
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
	  public void testDummyAccount() throws InterruptedException, IOException {
		  
		// load file
			File src=new File("data/dummyAccount.xlsx"); 
			
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
			System.out.println("login as Admin " + userName);
			
		    driver.get("http://localhost/ITECH3208_LanguageClub/loginpage.php");
		    driver.manage().window().setSize(new Dimension(1936, 1056));
		    driver.findElement(By.cssSelector(".whitebox")).click();
		    driver.findElement(By.id("username")).sendKeys(userName);
		    driver.findElement(By.id("password")).sendKeys(password);
		    driver.findElement(By.name("Login")).click();
			
		    //set sessionName
			cell = sheet.getRow(1).getCell(2); 
			cell.setCellType(CellType.STRING);  
			String sessionName = cell.getStringCellValue(); 
			//System.out.println(sessionName);
			
			//set sessionTime
			cell = sheet.getRow(1).getCell(3);							
			SimpleDateFormat dateFormat = new SimpleDateFormat("DD/MM/YYYY");
			String sessionDate = dateFormat.format(cell.getDateCellValue());
			//System.out.println(sessionDate);
			
			//set sessionTime
			cell = sheet.getRow(1).getCell(4);
			//SimpleDateFormat timeFormat = new SimpleDateFormat("h:mm a");
			SimpleDateFormat timeFormat = new SimpleDateFormat("h:mm");
			String sessionTime = timeFormat.format(cell.getDateCellValue());
			//System.out.println(sessionTime);
			
			//set am/pm
			cell = sheet.getRow(1).getCell(5); 
			cell.setCellType(CellType.STRING);  
			String amPm = cell.getStringCellValue(); 
			//System.out.println(amPm);
			
			//set position number
			cell = sheet.getRow(1).getCell(6); 
			cell.setCellType(CellType.STRING);  
			String positionNo = cell.getStringCellValue(); 
			//System.out.println(positionNo);	
			
		
		    //click createSession page
		    driver.findElement(By.linkText("Create Session")).click();
		    //enter value and then submit
		    driver.findElement(By.id("sname")).click();
		    driver.findElement(By.id("sname")).sendKeys(sessionName);
		    driver.findElement(By.id("sdate")).click();
		    driver.findElement(By.id("sdate")).sendKeys(sessionDate);
		    driver.findElement(By.id("stime")).click();
		    driver.findElement(By.id("stime")).sendKeys(sessionTime + amPm);
		    driver.findElement(By.cssSelector(".card")).click();				   
		    driver.findElement(By.xpath("//button[@type=\'submit\']")).click();
		    //accept alert message
		    String successfulFlag = driver.switchTo().alert().getText();
		    assertEquals(successfulFlag, "Successful");
		    
		    driver.switchTo().alert().accept();			 
		    Thread.sleep(1000);
		    
		    
		    driver.findElement(By.id("sname")).click();
		    //head back to home page to validate session is created
		    driver.findElement(By.linkText("Home")).click();

		    //retrieve date time for the session
		    String SessionDateTimeOutput = driver.findElement(By.cssSelector(".sessionCard:nth-child(" + positionNo + ") > .sessionText")).getText();			
		    //session date time from spreadsheet which is the data used to created new session
		    String sessionDateTimeInput = sessionDate+" "+ sessionTime + amPm; 
		    assertEquals(SessionDateTimeOutput, sessionDateTimeInput);
		    System.out.println("Session Date Time Matched. Actual: " + SessionDateTimeOutput + ", expected: " + sessionDateTimeInput);
		    //retrieve session name
		    driver.findElement(By.cssSelector(".sessionCard:nth-child(" + positionNo + ") .sessionButton")).click();
		    //match session name 
		    String sessionNameOutput =  driver.findElement(By.cssSelector("h1")).getText();
		    assertEquals(driver.findElement(By.cssSelector("h1")).getText(), sessionName );	
		    System.out.println ("Session Name Matched: actual: " +  sessionNameOutput + ", expected: " + sessionName);
		    
			
		    //join session
//				    driver.findElement(By.linkText("Home")).click();
//				    driver.findElement(By.cssSelector(".sessionCard:nth-child(" + positionNo + ") .sessionButton")).click();
//				    driver.findElement(By.name("join")).click();
			for(int i=1;  i<=sheet.getLastRowNum(); i++) { 			
				try	     
				{	
					//set account name
					cell = sheet.getRow(i).getCell(7); 
					cell.setCellType(CellType.STRING);  
					String dummyAccount = cell.getStringCellValue(); 
					//System.out.println(dummyAccount);	
					//sum up the input data and print out to console
					
					//set account language
					cell = sheet.getRow(i).getCell(8); 
					cell.setCellType(CellType.STRING);  
					String primaryLag = cell.getStringCellValue(); 
					
					//set account language
					cell = sheet.getRow(i).getCell(9); 
					cell.setCellType(CellType.STRING);  
					String expectedUserName = cell.getStringCellValue(); 
					
					System.out.println("Input session details: " + sessionName + " " + sessionDate + " "  + sessionTime + amPm + ". Add dummy asccount "+ dummyAccount+i );
					
				    
				    //add guest account 
				    driver.findElement(By.name("addGuest")).click();
				    driver.findElement(By.name("username")).click();
				    driver.findElement(By.name("username")).sendKeys(dummyAccount);
				    
				    driver.findElement(By.name("primarylag")).click();
				    {
				     //	use select drop down function			    
				      WebElement testDropDown  = driver.findElement(By.name("primarylag"));			    			      
				      Select dropdown  = new Select(testDropDown); 
				      
				     //change language base on value defined in the spreadsheet
				      dropdown.selectByVisibleText(primaryLag);		
				      
				    }
				    driver.findElement(By.name("reg_user")).click();
				    String accountName = driver.findElement(By.cssSelector("tr:nth-child(" + i + ") > td:nth-child(1)")).getText();
				    assertEquals (accountName, expectedUserName);
				    String accountEmail = driver.findElement(By.cssSelector("tr:nth-child(" + i +") > td:nth-child(2)")).getText();
				    assertEquals (accountEmail, expectedUserName+"@dummyAccount.com");
				    String acccountLanguage = driver.findElement(By.cssSelector("tr:nth-child(" + i +") > td:nth-child(3)")).getText();
				    assertEquals (acccountLanguage, primaryLag);
				    String role = driver.findElement(By.cssSelector("tr:nth-child(" + i +") > td:nth-child(4)")).getText();
				    assertEquals (role, "Guest");
				    
				    String membersNo = driver.findElement(By.cssSelector("h2:nth-child(2)")).getText();
				    //validate total number of participants is correct (same as spreadsheet input)				      
				    assertTrue(membersNo.contains("Members"+" "+i+"/50"));
				    
				    System.out.println ("Session Participant Details: " + System.lineSeparator() + membersNo);
  
				   
				    
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
