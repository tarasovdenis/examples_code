/*Нахождение Top-20 используемых слов в тексте*/

import java.io.*;
import java.util.*;

class lab3 {
	public static void main(String[] args) throws IOException {
		String lines = new String();

		BufferedReader fin = new BufferedReader(new InputStreamReader(new FileInputStream("e:\\text.txt")));
		while (fin.ready()) {
			lines += fin.readLine() + "\n";
		}
		fin.close();

		String arr[] = lines.split("[^A-Za-zА-ЯЁа-яё0-9]+");

		Map<String, Integer> map = new HashMap<String, Integer>();
		for (String word : arr) {
			if (map.containsKey(word))
				map.put(word, map.get(word) + 1);
			else
				map.put(word, 1);
		}

		List list = new ArrayList(map.entrySet());
		Collections.sort(list, new Comparator<Map.Entry<String, Integer>>() {
			public int compare(Map.Entry<String, Integer> e1, Map.Entry<String, Integer> e2) {
				return e2.getValue() - e1.getValue();
			}
		});

		for (int i = 0; i < 20; i++) {
			System.out.println(list.get(i));
		}
	}
}