package ru.tarasov.solid.valid;

import ru.tarasov.solid.exception.InputException;
import ru.tarasov.solid.exception.NegArgOfSqrtException;

//регулярное выражение для операции SQRT
public interface ISqrtRegexValid {
	boolean sqrtValid(String expression) throws NegArgOfSqrtException, InputException;
}
