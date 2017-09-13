package ru.tarasov.solid;

//вычисление
public class Computational<T>{
	<T extends Number> T comp(T op1, T op2){
		return null;
	};
}

class Summ<T extends Number> extends Computational<T> {
	public <T extends Number> T comp(T op1, T op2) {
		return (T) new Integer(op1.intValue() + op2.intValue());
	}
}

class Diff<T extends Number> extends Computational<T> {
	public <T extends Number> T comp(T op1, T op2) {
		return (T) new Integer(op1.intValue() - op2.intValue());
	}
}

class Mult<T extends Number> extends Computational<T> {
	public <T extends Number> T comp(T op1, T op2) {
		return (T) new Integer(op1.intValue() * op2.intValue());
	}
}

class Div<T extends Number> extends Computational<T> {
	public <T extends Number> T comp(T op1, T op2) {
		if(op2.doubleValue() == 0.0)
			throw new ArithmeticException();
		return (T) new Double(op1.doubleValue() / op2.doubleValue());
	}
}

class Sqrt<T extends Number> extends Computational<T> {
	public <T extends Number> T comp(T op1, T op2) {
		return (T) new Double(Math.sqrt(op1.doubleValue()));
	}
}

class Sqr<T extends Number> extends Computational<T> {
	public <T extends Number> T comp(T op1, T op2) {
		return (T) new Integer(op1.intValue() * op1.intValue());
	}
}