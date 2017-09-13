package ru.tarasov.solid.expression;

import java.util.ArrayList;
import java.util.Iterator;

public class Operator {
	private String expression;	//выражение
	private OperatorList ol;
	
	public Operator(String str, OperatorList ol){
		expression = str;
		this.ol = ol;
	}
	
	//получить оператор
	public String getOperator(){
		String tmp;
		Iterator<String> list_operation = ol.list_operation_iterator();
		while(list_operation.hasNext()){
			tmp = list_operation.next();
			if(expression.contains(tmp))
					return tmp;
		}
		return null;
	}
	
	//получить номер позиции оператора в выражении
	public int getIndexOperator(){
		String tmp;
		Iterator<String> list_operation = ol.list_operation_iterator();
		while(list_operation.hasNext()){
			tmp = list_operation.next();
			if(expression.contains(tmp))
					return expression.indexOf(tmp);
		}
		return -1;
	}
}
