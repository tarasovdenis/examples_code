package ru.tarasov.solid.expression;

public class Operand {
	protected String stringOperand;	//строковое представление операнда
	protected String expression;	//выражение
	protected int op;				//операнд
	
	public Operand(String expression){
		this.expression = expression;
	}
	
	//извлчение операнда
	//num - номер операнда
	//indexOperatora - индекс оператора в выражении
	public int Partition(int num, int indexOperator){
		if(num == 1)
			stringOperand = expression.substring(0, indexOperator);
		else
			stringOperand = expression.substring(indexOperator+1, expression.length());
		op = Integer.valueOf(stringOperand);
		return op;
	}
	
	//
	public int get(){
		return Integer.valueOf(stringOperand);
	}
}
