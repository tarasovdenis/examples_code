package ru.tarasov.solid.valid;

import ru.tarasov.solid.exception.InputException;

//регулярное выражение для двустных операций
public interface IExpressionRegexValid {
	boolean expValid(String expression) throws InputException;
}
