package data.test;

import static org.junit.jupiter.api.Assertions.*;

import java.util.ArrayList;
import java.util.Date;

import org.junit.internal.TextListener;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.junit.runner.JUnitCore;
import org.junit.runner.Result;

import data.*;
import functions.*;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;

import java.io.IOException;

import java.io.PrintStream;

import java.text.SimpleDateFormat;
import java.util.NoSuchElementException;

import org.apache.poi.ss.usermodel.CellType;
import org.apache.poi.xssf.usermodel.XSSFCell;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;



public class PairingTest {

	
	public static void main(String args[]) {
		  
		  JUnitCore junit = new JUnitCore();
		  junit.addListener(new TextListener(System.out));
		  Result result = junit.run(PairingTest.class); // Replace "SampleTest" with the name of your class
		  if (result.getFailureCount() > 0) {
		    System.out.println("Test failed.");
		    System.exit(1);
		  } else {
		    System.out.println("Test finished successfully.");
		    System.exit(0);
		  }
	}	  
	  

	@BeforeEach
	void setUp() throws Exception {	  
		
	}

	@Test
	void test() throws IOException {
		
		//return desktop location
		File desktop = new File(System.getProperty("user.home") + File.separator + "Desktop");
		String s = desktop.toString();
		String deskTopPath = s.replace("\\", "/");
		
		
	    //Creating a Output directory under Paddy to collect all generated output files
	    File file = new File(deskTopPath+"/Paddy/Report");
	    //Creating the directory
	    file.mkdir();
		
	    //initial workbook
		XSSFWorkbook workbook;
		XSSFSheet sheet;
		XSSFCell cell; 
	 
		//setup the file path and locate the file
		File src=new File(deskTopPath+"/Paddy/user.xlsx");
			
		FileInputStream finput = new FileInputStream(src); 
		
		// Load the workbook. 

		workbook = new XSSFWorkbook(finput); 

		// Load the sheet in which data is stored. 

		sheet= workbook.getSheetAt(0); 		
		
		ArrayList<User> users = new ArrayList<User>();
		
//		Auto generate pair function, comment out in case need to reuse 
//		for(int i = 1; i < 11; i++) {
//			int japanSkill;
//			int englishSkill;
//			if(i % 2 == 0) {
//				japanSkill = 3;
//				englishSkill = 0;
//			} else {
//				japanSkill = 0;
//				englishSkill = 3;
//			}
//			String name = "User " + Integer.toString(i);
//			users.add(new User(i, name, japanSkill, englishSkill));
//		}
		
		for(int i=1;  i<=sheet.getLastRowNum(); i++) { 			
			
			
			try	     
				{

					//set userID
					cell = sheet.getRow(i).getCell(0); 
					cell.setCellType(CellType.NUMERIC);  
					int userID = (int) cell.getNumericCellValue();
			
				
					//set userName
					cell = sheet.getRow(i).getCell(1); 
					cell.setCellType(CellType.STRING);  
					String userName = cell.getStringCellValue(); 
			
					
					cell = sheet.getRow(i).getCell(2); 
					cell.setCellType(CellType.NUMERIC);  
					int japanSkill = (int) cell.getNumericCellValue();
			
				
					//set englishSkill
					cell = sheet.getRow(i).getCell(3); 
					cell.setCellType(CellType.NUMERIC);  
					int englishSkill = (int) cell.getNumericCellValue();
			
					users.add(new User(userID, userName, japanSkill, englishSkill));		

				}
			
	
			catch (NoSuchElementException ne)
	        {     	
			     ne.printStackTrace();
	        }				
		   
			catch (Throwable t)
		    {
		       t.printStackTrace();
		    }
				
				workbook.close();
		} 	
		
		
		Session session = new Session("firstSession", null, 0);
		assertEquals(session.getName(), "firstSession");
		Function.randomiseArray(users);
		session.pairUsers(users);	
		//Print to the console
		session.sessionToString();	

		//create a file and print to the file in Report folder: deskTopPath + "/Paddy/Report/{{file Name}}
		Date date = new Date() ;
		SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd HH-mm-ss") ;
		File file2 = new File(deskTopPath + "/Paddy/Report/" + "Pairing - " + dateFormat.format(date) + ".txt") ;
		PrintStream printStream = new PrintStream(new FileOutputStream(file2));
		System.setOut(printStream);		
		session.sessionToString();

	
	}

}
