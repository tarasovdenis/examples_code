package ru.tarasov.solid.expression;

import java.util.ArrayList;
import java.util.Iterator;

import ru.tarasov.solid.Computational;

//список операторов
public class OperatorList {
	private static ArrayList<String> list_operation = new ArrayList<>();
	private static ArrayList<Computational<?>> operations = new ArrayList<>();

	//добавить опператор
	public void addOperator(String op, Computational<?> method) {
		list_operation.add(op);
		operations.add(method);
	}
	
	//итератор для списка операций
	public Iterator<String> list_operation_iterator(){
		return list_operation.iterator();
	}
	
	//полусение метода по указанному индексу
	public Computational<?> getOperation(int index){
		return operations.get(index);
	}

	//индекс оператора в списке
	public static int getIndexToList(String op) {
		for (int i = 0; i < list_operation.size(); i++) {
			if (list_operation.get(i).equals(op))
				return i;
		}
		return -1;
	}
}