package itech3209;
import static org.junit.Assert.assertEquals;

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
import org.openqa.selenium.chrome.ChromeDriver;

/* this class tests the session creation process. 
 * It creates a session and then validate the session is created successful by 
 * checking the datetime and session names are matched. 
 */

public class session {

	private WebDriver driver;	
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
	}
	
	@After
	public void tearDown() {
	 driver.quit();
	}

	@Test
	public void testSession() throws InterruptedException, IOException {
		// load file
		File src=new File("data/session.xlsx"); 
		
		FileInputStream finput = new FileInputStream(src); 
		
		// Load the workbook. 

		workbook = new XSSFWorkbook(finput); 

		// Load the sheet in which data is stored. 

		sheet= workbook.getSheetAt(0); 
		//set userName
		cell = sheet.getRow(1).getCell(0); 
		cell.setCellType(CellType.STRING);  
		String userName = cell.getStringCellValue(); 
		System.out.println(userName);
	
		//set password
		cell = sheet.getRow(1).getCell(1); 
		cell.setCellType(CellType.STRING);  
		String password = cell.getStringCellValue(); 
		System.out.println(password);
		
		// start registration process				
	    driver.get("http://localhost/ITECH3208_LanguageClub/loginpage.php");
	    driver.manage().window().setSize(new Dimension(1936, 1056));
	    driver.findElement(By.cssSelector(".whitebox")).click();
	    driver.findElement(By.id("username")).sendKeys(userName);
	    driver.findElement(By.id("password")).sendKeys(password);
	    driver.findElement(By.name("Login")).click();	
	    
		for(int i=1;  i<=sheet.getLastRowNum(); i++) { 	
			
		
			try	   
			{	
				
				
				//set sessionName
				cell = sheet.getRow(i).getCell(2); 
				cell.setCellType(CellType.STRING);  
				String sessionName = cell.getStringCellValue(); 
				System.out.println(sessionName);
				
				//set sessionTime
				cell = sheet.getRow(i).getCell(3);							
				SimpleDateFormat dateFormat = new SimpleDateFormat("DD/MM/YYYY");
				String sessionDate = dateFormat.format(cell.getDateCellValue());
				System.out.println(sessionDate);
				
				//set sessionTime
				cell = sheet.getRow(i).getCell(4);
				//SimpleDateFormat timeFormat = new SimpleDateFormat("h:mm a");
				SimpleDateFormat timeFormat = new SimpleDateFormat("h:mm");
				String sessionTime = timeFormat.format(cell.getDateCellValue());
				System.out.println(sessionTime);
				
				//set am/pm
				cell = sheet.getRow(i).getCell(5); 
				cell.setCellType(CellType.STRING);  
				String amPm = cell.getStringCellValue(); 
				System.out.println(amPm);
				
				//set position number
				cell = sheet.getRow(i).getCell(6); 
				cell.setCellType(CellType.STRING);  
				String positionNo = cell.getStringCellValue(); 
				System.out.println(positionNo);				
			

			    //click createSession page
			    driver.findElement(By.linkText("Create Session")).click();
			    driver.findElement(By.id("sname")).click();
			    driver.findElement(By.id("sname")).sendKeys(sessionName);
			    driver.findElement(By.id("sdate")).click();
			    driver.findElement(By.id("sdate")).sendKeys(sessionDate);
			    driver.findElement(By.id("stime")).click();
			    driver.findElement(By.id("stime")).sendKeys(sessionTime + amPm);
			    driver.findElement(By.cssSelector(".card")).click();
			    //driver.findElement(By.id("stime")).sendKeys("18:22PM");	 
			   
			    driver.findElement(By.xpath("//button[@type='submit']")).click();
			    //accept alert message
			    String successfulFlag = driver.switchTo().alert().getText();
			    assertEquals(successfulFlag, "Successful");
			    
			    driver.switchTo().alert().accept();			 
			    Thread.sleep(3000);
			    
			    
			    driver.findElement(By.id("sname")).click();
			    //head back to home page to validate session is created
			    driver.findElement(By.linkText("Home")).click();
			    
			    
			    //retrieve date time for the session
			    String SessionDateTimeOutput = driver.findElement(By.cssSelector(".sessionCard:nth-child(" + positionNo + ") > .sessionText")).getText();			
			    //session date time from spreadsheet which is the data used to created new session
			    String sessionDateTimeInput = sessionDate+" "+ sessionTime + amPm; 
			    assertEquals(SessionDateTimeOutput, sessionDateTimeInput);
			    System.out.println("Session Date Time Matched. Actual: " + SessionDateTimeOutput + "Expected: " + sessionDateTimeInput);
			    //retrieve session name
			    driver.findElement(By.cssSelector(".sessionCard:nth-child(" + positionNo + ") .sessionButton")).click();
			    //match session name 
			    String sessionNameOutput =  driver.findElement(By.cssSelector("h1")).getText();
			    assertEquals(driver.findElement(By.cssSelector("h1")).getText(), sessionName );	
			    System.out.println ("Session Name Matched: actual: " +  sessionNameOutput + "expected: " + sessionName);	    
			    
			    
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