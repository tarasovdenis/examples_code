package ru.tarasov.solid.valid;

//проверка выражения на наличие операций SQR и SQRT
public class IsValid implements ISqrtIsValid, ISqrIsValid{

	private String expression;
	
	public IsValid(String expression){
		this.expression = expression;
	}
	
	//true - если выражение содержит операцию sqrt
	@Override
	public boolean SqrtIsValid() {
		if(expression.contains("sqrt"))
			return true;
		return false;
	}

	//true - если выражение содержит операцию sqr
	@Override
	public boolean SqrIsValid() {
		//и не содержит операцию sqrt
		if(expression.contains("sqr") & !expression.contains("sqrt"))
			return true;
		return false;
	}

}
