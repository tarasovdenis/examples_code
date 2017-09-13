package ru.tarasov.solid.valid;

import ru.tarasov.solid.exception.InputException;

//регулярное выражение для операции SQR
public interface ISqrRegexValid{
	boolean sqrValid(String expression) throws InputException;
}
