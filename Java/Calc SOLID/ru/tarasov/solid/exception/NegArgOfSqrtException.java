package ru.tarasov.solid.exception;

public class NegArgOfSqrtException extends Exception{
	public String toString(){
		return "Невозможно выполнить извлечение квадратного корня из отрицательного числа!";
	}
}
