package data;

import java.util.ArrayList;

public class User {
	private int id;
	private String name;
	private int japanSkill;
	private int englishSkill;
	private ArrayList<User> recentPairs;
	
	public User(int id, String name, int japanSkill, int englishSkill){
		this.id = id;
		this.name = name;
		this.japanSkill = japanSkill;
		this.englishSkill = englishSkill;
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public int getJapanSkill() {
		return japanSkill;
	}

	public void setJapanSkill(int japanSkill) {
		this.japanSkill = japanSkill;
	}

	public int getEnglishSkill() {
		return englishSkill;
	}

	public void setEnglishSkill(int englishSkill) {
		this.englishSkill = englishSkill;
	}

	public ArrayList<User> getRecentPairs() {
		return recentPairs;
	}

	public void appendRecentPairs(User user) {
		this.recentPairs.add(user);
	}
	
	public String getNativeLanguage() {
		String language;
		if(getJapanSkill() < getEnglishSkill()) {
			language = "English";
		} else {
			language = "Japanese";
		}
		return language;
	}
	
	public String skillToString(int skillLevel) {
		switch (skillLevel) {
        case 0:
            return "Beginner";
        case 1:
            return "Intermediate";
        case 2:
            return "Fluent";
        case 3:
            return "Primary";
        default:
            return "Data Error";
		}
    }

	
	
	
}
