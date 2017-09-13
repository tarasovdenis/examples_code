package ru.tarasov.solid.expression;

//извлечение операнда из функции
public class OpInFunc extends Operand{
	
	public OpInFunc(String expression) {
		super(expression);
		int RindexBkt, LindexBkt;
		LindexBkt = super.expression.indexOf("(");
		RindexBkt = super.expression.indexOf(")");
		super.stringOperand = super.expression.substring(LindexBkt+1, RindexBkt);
	}
	
}
