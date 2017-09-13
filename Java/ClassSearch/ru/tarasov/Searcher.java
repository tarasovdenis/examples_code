package ru.tarasov;

import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.Stack;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

/*
 * ѕоиск класса по имени.
 * ƒл€ реализации поиска используетс€ бинарное дерево.
*/

//данные на каждом узле
class nodeData implements Comparable<nodeData> {
	private String className;
	private Long modificationDate;

	//лексикографическое сравнение
	@Override
	public int compareTo(nodeData o) {
		return className.compareTo(o.className);
	}

	public String getClassName() {
		return className;
	}

	public Long getDate() {
		return modificationDate;
	}

	public void setClassName(String name) {
		className = name;
	}

	public void setModificationDate(Long date) {
		modificationDate = date;
	}
}

// узел
class Node {
	private nodeData root;
	private Node left;
	private Node right;

	Node(String className, Long modificationDate) {
		root = new nodeData();
		root.setClassName(className);
		root.setModificationDate(modificationDate);
	}

	public nodeData getNode() {
		return root;
	}

	public Node getLeft() {
		return left;
	}

	public Node getRight() {
		return right;
	}

	public void setLeft(Node l) {
		left = l;
	}

	public void setRight(Node r) {
		right = r;
	}
}

// бинарное дерево
class BinaryTree {
	private Node root, tmp;

	//корень
	Node getRoot() {
		return root;
	}

	// вставка нового узла
	void insert(String className, Long modificationDate) {
		Node node = new Node(className, modificationDate);
		if (root == null) {
			root = node;
			return;
		}

		tmp = root;

		while (tmp != null) {
			if (tmp.getNode().compareTo(node.getNode()) > 0) {
				if (tmp.getLeft() != null) {
					tmp = tmp.getLeft();
					continue;
				} else {
					tmp.setLeft(node);
					break;
				}
			} else {
				if (tmp.getRight() != null) {
					tmp = tmp.getRight();
					continue;
				} else {
					tmp.setRight(node);
					break;
				}
			}
		}
	}

	// концевой обход дерева (левое поддерево, правое поддерево, корень поддерева)
	ArrayList<Node> postOrder(Node top, String str) {
		Stack<Node> stack = new Stack<>();
		ArrayList<Node> result = new ArrayList<>();
		while (top != null || !stack.empty()) {
			if (!stack.empty()) {
				top = stack.pop();
				if (!stack.empty() && top.getRight() == stack.lastElement()) {
					top = stack.pop();
				} else {
					if (top.getNode().getClassName().startsWith(str))
						result.add(top);
					top = null;
				}
			}
			while (top != null) {
				stack.push(top);
				if (top.getRight() != null) {
					stack.push(top.getRight());
					stack.push(top);
				}
				top = top.getLeft();
			}
		}
		if (result.size() == 0)
			return null;
		return result;
	}

	// упор€дочивание списка классов
	void sort(ArrayList<Node> list) {
		Collections.sort(list, new Comparator<Node>() {
			@Override
			public int compare(Node ob1, Node ob2) {
				// лексикографически
				if (ob1.getNode().getDate().equals(ob2.getNode().getDate())) {
					return ob1.getNode().getClassName().compareTo(ob2.getNode().getClassName());
				}
				// по дате изменени€
				return ob1.getNode().getDate().compareTo(ob2.getNode().getDate());
			}

		});
	}
}

public class Searcher implements ISearcher {
	private BinaryTree bt;
	private final int MAX_SIZE = 13;

	public Searcher() {
		bt = new BinaryTree();
		
	}

	// проверка имени класса
	private boolean check(String str) {
		Pattern regexp = Pattern.compile("^[a-zA-Z0-9.-]+$");
		Matcher m = regexp.matcher(str);
		if (str.length() > 32 | !m.matches())
			return false;
		return true;
	}

	@Override
	public void refresh(String[] classNames, long[] modificationDates) {
		for (int i = 0; i < classNames.length; i++) {
			// проверка имени класса
			if (!check(classNames[i])) {
				return;
			}
			bt.insert(classNames[i], modificationDates[i]);
		}
	}

	@Override
	public String[] guess(String start) {
		String [] result;
		
		try{
			ArrayList<Node> list = bt.postOrder(bt.getRoot(), start);
			bt.sort(list);
			int length;
			if(list.size() > 12)
				length = 12;
			else
				length = list.size();
			result = new String[length];
			for(int i = 0; i < length; i++)
				result[i] = list.get(i).getNode().getClassName();
		}
		catch(NullPointerException exc){
			//ничего не найдено
			return null;
		}
		
		return result;
	}

}
