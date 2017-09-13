package ru.tarasov.solid.valid;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

import ru.tarasov.solid.exception.InputException;
import ru.tarasov.solid.exception.NegArgOfSqrtException;

//проверка соответсвия ВВЕДЕННОГО ВЫРАЖЕНИЯ регулярному выражению
public class RegexValid implements ISqrtRegexValid, ISqrRegexValid, IExpressionRegexValid{

	@Override
	//операция SQRT
	public boolean sqrtValid(String expression) throws NegArgOfSqrtException, InputException {
		String regex1 = "^(sqrt\\(-?[0-9]+\\))$";
		String regex2 = "^(sqrt\\([0-9]+\\))$";
		Pattern p1 = Pattern.compile(regex1);
		Pattern p2 = Pattern.compile(regex2);
		Matcher m1 = p1.matcher(expression);
		Matcher m2 = p2.matcher(expression);
		if (!m1.matches())
			throw new InputException();			//ошибка ввода
		if (!m2.matches())
			throw new NegArgOfSqrtException();	//отрицательный аргумент
		return true;
	}

	@Override
	//операция SQR
	public boolean sqrValid(String expression) throws InputException {
		String regex = "^(sqr\\(-?[0-9]+\\))$";
		Pattern p = Pattern.compile(regex);
		Matcher m = p.matcher(expression);
		if (!m.matches())
			throw new InputException();			//ошибка ввода
		return true;
	}

	//для двуместных операций 
	@Override
	public boolean expValid(String expression) throws InputException {
		String regex = "^([0-9]+[\\+\\-\\*\\/][0-9]+)$";
		Pattern p = Pattern.compile(regex);
		Matcher m = p.matcher(expression);
		if(!m.matches())
			throw new InputException();			//ошибка ввода
		return true;
	}

}
