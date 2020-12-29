package data;

import java.util.ArrayList;
import java.util.Date;

public class Session {
	private String name;
	private Date dateTime;
	private int capacity;
	private ArrayList<Group> groups = new ArrayList<Group>();
	
	public Session(String name, Date dateTime, int capacity){
		this.name = name;
		this.dateTime = dateTime;
		this.capacity = capacity;
		this.addNewGroup();
	}
	
	public String getName() {
		return this.name;
	}
	
	public Date getDateTime() {
		return this.dateTime;
	}
	
	public int getCapacity() {
		return this.capacity;
	}
	
	public ArrayList<Group> getGroups(){
		return this.groups;
	}
	
	public void setGroups(ArrayList<Group> groups) {
		this.groups = groups;
	}
	
	public void addNewGroup() {
		this.groups.add(new Group());
	}
	
	public void pairUsers(ArrayList<User> users){
		//ArrayList<User> unsortedUsers = new ArrayList<User>();
		if(users != null && users.size() > 1) {
			for(int i = 0; i < users.size(); i++) {
				Boolean userPaired = false;
				Group group;
				while(!userPaired) {
					for(int groupNo = 0; groupNo < this.getGroups().size(); groupNo++) {
						group = this.getGroups().get(groupNo);
						if(!group.validGrouping() && !group.hasPrimaryLanguage(users.get(i).getNativeLanguage())) {
							group.addUserToGroup(users.get(i));
							userPaired = true;
							if(userPaired) {
								break;}
							
						} else {
							if(groupNo == this.getGroups().size() - 1) {
								this.addNewGroup();
							}
						}
						if(userPaired) {
							break;
						}
					}
				}
			}
			users = this.dissolveInvalidGroups();
			sortRemainingUsers(users);
			
		}
		
		
	}
	
	public ArrayList<User> dissolveInvalidGroups(){
		ArrayList<User> unsortedUsers = new ArrayList<User>();
		ArrayList<Group> validGroups = new ArrayList<Group>();
		for(int i = 0; i < this.getGroups().size(); i++) {
			if(!this.getGroups().get(i).validGrouping()) {
				for(int j = 0; j < this.getGroups().get(i).getParticipants().size(); j++) {
					unsortedUsers.add(this.getGroups().get(i).getParticipants().get(j));
				}
			} else {
				validGroups.add(this.getGroups().get(i));
			}
		}
		this.setGroups(new ArrayList<Group>());
		this.setGroups(validGroups);
		return unsortedUsers;
	}
	
	public void sortRemainingUsers(ArrayList<User> users) {
		if(users.size() > 0) {
			//One Person
			if(users.size() == 1) {
				int randomIndex = (int) (Math.random() * this.getGroups().size()) % this.getGroups().size();
				this.getGroups().get(randomIndex).addUserToGroup(users.get(0));
			//Even Number
			} else if(users.size() % 2 == 0) {
				for(int i = 0; i < users.size(); i += 2) {
					this.addNewGroup();
					this.getGroups().get(this.getGroups().size()-1).addUserToGroup(users.get(i));
					this.getGroups().get(this.getGroups().size()-1).addUserToGroup(users.get(i + 1));
				}
			//Odd Number	
			} else {
				for(int i = 0; i < users.size()-3; i += 2) {
					this.addNewGroup();
					this.getGroups().get(this.getGroups().size()-1).addUserToGroup(users.get(i));
					this.getGroups().get(this.getGroups().size()-1).addUserToGroup(users.get(i + 1));
				}
				this.addNewGroup();
				this.getGroups().get(this.getGroups().size()-1).addUserToGroup(users.get(users.size()- 1));
				this.getGroups().get(this.getGroups().size()-1).addUserToGroup(users.get(users.size()- 2));
				this.getGroups().get(this.getGroups().size()-1).addUserToGroup(users.get(users.size()- 3));
			}
		}
	}
	
	public void sessionToString() {
		for(int i =0; i < this.groups.size(); i++) {
			for(int j = 0; j < this.groups.get(i).getParticipants().size(); j++) {
				System.out.print("Group Number " + (i+1) + " : ");
				System.out.print(this.groups.get(i).getParticipants().get(j).getName()+ " ");
				System.out.println(this.groups.get(i).getParticipants().get(j).getNativeLanguage());	
				
			}
			System.out.println("------------------------------------");
		}
	}
	
}
