import java.util.ArrayList;
import java.util.Scanner;
import java.util.regex.Pattern;

public class TestWiki {
	public static void main(String [] args){
		ArrayList<String> strs = new ArrayList<>();
		String temp;
		int arr [];
		
		Scanner scan1 = new Scanner(System.in);
		
		while(scan1.hasNextLine()){
			temp = scan1.nextLine().trim();
			if(!temp.isEmpty())
				strs.add(temp);
		}
		
		arr = new int[strs.size()];
		
		for(int i = 0; i < strs.size()-1; i++){
			String tek = strs.get(i);
			String next = strs.get(i + 1);
			if(tek.charAt(0) == '*'){			
				if(next.charAt(0) == '*'){		
					arr[i] = 1;
					arr[i + 1] = 1;
				}else{							
					if(arr[i] != 1){
						tek = tek + " " +next;
						strs.set(i, tek);
						strs.remove(i + 1);
						arr[i] = 2;
						arr[i + 1] = 2;
					}
				}
			}else{
				if(next.charAt(0) != '*'){
					tek = tek + " " + next;
					strs.set(i, tek);
					strs.remove(i+1);
					arr[i] = 2;
					i = i - 1;
				}
			}
		}
		
		//удаление лишних пробелов
		for(int i = 0; i < strs.size(); i++){
			temp = strs.get(i).trim();
			if(temp.charAt(0) == '*' & arr[i] == 1)
				temp = temp.substring(1).trim();
			strs.set(i,temp.replaceAll("\\s+", " "));
		}
		
		//вывод
		boolean flag = false; 
		for(int i = 0; i < strs.size(); i++){
			if(arr[i] == 2){
				if(flag){
					System.out.println("</ul>");
					flag = false;
				}
				System.out.println("<p>" + strs.get(i) + "</p>");
			}
			
			if(arr[i] == 1){
				if(i == 0){
					flag = true;
					System.out.println("<ul>\n<li>" + strs.get(i) + "</li>");
				}else{ 
					if(flag){
						System.out.println("<li>" + strs.get(i) + "</li>");
					}else{
						System.out.println("<ul>\n<li>" + strs.get(i) + "</li>");
						flag = true;
					}
				}
			}
		}
		if(flag)
			System.out.println("</ul>");
	}
}
