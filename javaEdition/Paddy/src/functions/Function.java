package functions;

import java.util.ArrayList;

import data.User;

public class Function {
	public static ArrayList<User> randomiseArray(ArrayList<User> users){
		//This sets a variable for the selection of elements.
				int j = users.size()-1;
				
				//While loop for iterating backwards through the array.
				while(j>1) {
					
					//Random number between 0 and 1.
					double U = Math.random();
					
					//This multiplies the random number by the iterator floor is used to round down avoiding the chance of an out of bounds exception.
					int k = (int) Math.floor((j+1)*U);
					
					//This swaps the elments from the two positions.
					swap(users, j, k);
					j--;
					
				}
		return users;
	}
	
	//This method is for swapping the position of 2 elements in an array.
		public static void swap(ArrayList<User> users, int x, int y){
			User a = users.get(x);
			User b = users.get(y);
			users.set(x, b);
			users.set(y, a);
		}
}
