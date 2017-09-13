import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.Scanner;

public class XMLTest {
	public static void main(String [] args) {
		ArrayList<String> strs = new ArrayList<>();
		ArrayList<Member> members = new ArrayList<>();
		ArrayList<MemberResult> memberResults = new ArrayList<>();
		String temp;

		//чтение данных
		Scanner scan = new Scanner(System.in);
		while (scan.hasNextLine()) {
			temp = scan.nextLine();
			if (temp.trim().isEmpty())
				break;
			strs.add(temp);
		}
		
		//парсинг XML
		for(String s : strs){
			if(s.contains("project") & !s.contains("projects") & !s.contains("/project")){
				int firstIndex = s.indexOf("name") + "name=\"".length();
				int lastIndex = s.lastIndexOf("\"");
				Project.name = s.substring(firstIndex, lastIndex);
			}
			
			if(s.contains("member")){
				Member m = new Member();
				int firstIndex = s.indexOf("role") + "role=\"".length();
				int lastIndex = firstIndex+1;
				while(s.charAt(lastIndex) != '\"')
					++lastIndex;
				m.role = s.substring(firstIndex, lastIndex);
				
				firstIndex = s.indexOf("name") + "name=\"".length();
				lastIndex = firstIndex+1;
				while(s.charAt(lastIndex) != '\"')
					++lastIndex;
				m.name = s.substring(firstIndex, lastIndex);
				
				m.project = Project.name;
				members.add(m);
			}
		}
		
		//преобразование
		MemberResult tempMR = new MemberResult();
		tempMR.name = members.get(0).name;
		memberResults.add(tempMR);
		boolean flag;
		for(Member m : members){
			flag = false;
			for(MemberResult mr : memberResults){
				if(m.name.equals(mr.name)){
					flag = true;
				}
			}
			if(!flag){
				tempMR = new MemberResult();
				tempMR.name = m.name;
				memberResults.add(tempMR);
			}
		}
		
		for(MemberResult mr : memberResults){
			for(Member m : members){
				if(mr.name.equals(m.name)){
					String r[] = new String [2];
					r[0] = new String(m.role);
					r[1] = new String(m.project);
					mr.role_project.add(r);
				}
			}
		}
		
		//сортировки
		Collections.sort(memberResults, new Comparator<MemberResult>(){

			@Override
			public int compare(MemberResult o1, MemberResult o2) {
				return o1.name.compareTo(o2.name);
			}
			
		});
		
		for(MemberResult mr : memberResults){
			Collections.sort(mr.role_project, new Comparator<String []>(){

				@Override
				public int compare(String[] o1, String[] o2) {
					if(o1[1].compareTo(o2[1]) == 0){
						return o1[0].compareTo(o2[0]);
					}
					return o1[1].compareTo(o2[1]);
				}

			});
		}
		
		//вывод
		System.out.println("<members>");
		for(MemberResult mr : memberResults){
			System.out.println("    <member name=\"" + mr.name + "\">");
			for(String [] rp : mr.role_project){
				System.out.println("        <role name=\"" + rp[0] + "\" project=\"" + rp[1] + "\"/>");
			}			
			System.out.println("    </member>");
		}
		System.out.println("</members>");
	}
}

class Project{
	static String name;
}

class Member{
	String role;
	String name;
	String project;
}

class MemberResult{
	String name;
	ArrayList<String[]> role_project = new ArrayList<>();
}
