package data;

import java.util.ArrayList;

public class Group {
	ArrayList<User> participants = new ArrayList<User>();
	Group(){
		
	}
	
	public Boolean validGrouping() {
		Boolean hasJapanese = false;
		Boolean hasEnglish = false;
		for(int i = 0; i < participants.size(); i++) {
			if(participants.get(i).getEnglishSkill() == 3) {
				hasEnglish = true;
			} else {
				hasJapanese = true;
			}
		}
		
		if(hasJapanese && hasEnglish) {
			return true;
		} else {
			return false;
		}		
	}
	
	public Boolean hasPrimaryLanguage(String language) {
		Boolean hasLanguage = false;
		for(int i = 0; i < participants.size(); i++) {
			if(participants.get(i).getNativeLanguage() == language) {
				hasLanguage = true;
			}
		}
		return hasLanguage;
	}
	
	public Boolean checkIfPairedRecently(User user) {
		if(participants.size() >= 1) {
			for(int i = 0; i < participants.size(); i++) {
				ArrayList<User> participantHistory = participants.get(i).getRecentPairs();
				for(int j = 0; j < participantHistory.size(); j++) {
					if(participantHistory.get(j).getId() == user.getId()) {
						return true;
					}
				}
			}
		} 
		return false;
		
	}
	
	public void addUserToGroup(User user) {
		this.participants.add(user);
	}
	
	public ArrayList<User> getParticipants(){
		return participants;
	}
	
}
