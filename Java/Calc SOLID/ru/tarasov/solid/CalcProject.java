/*
Калькулятор выполнен с использованием методологии SOLID.
Испольльзуются следующие принципы
	- Принцип единственности ответственности
	- Принцип открытости/закрытости
	- Принцип разделения интерфейсов
	- Принцип замещения Лисков 

- Принцип единственности ответственности
	1. классы разбиты по пакетам: основной, исключения, ввод, проверка.
	2. Например для получения операндов и операций используется свой класс
	3. Для проверки выражения используется отдельный класс
	4. Для исключений используется отдельный класс
	5. Для каждого метода вычисления используется отдельный класс

-Принцип открытости/закрытости
	1.Сущности открыты для расширений, но не для изменений.
	2.Например, в методе вычисления нет необходимости добавлять новые условия и операторы, 
соответсвующие этому условию. Достаточно добавить новую операцию в список операций, а также
создать класс, наследющий суперкласс для вычисления, в котором переопределить нужно 
соответствующий метод.
	3. А также для получения операнда из функции не приходится изменять класс Operand,
а создается класс (наследуемый от Operand) для пролучения операнда из функции Sqr, Sqrt 

-Принцип разделения интерфейсов
	1.Интерфесы на забиты множестовом разнородных методов
	2.Каждый интерфейс представляет отдельный набор методов, который можно исключить из реализации
без необходимости использования.

КРОМЕ ТОГО
-Используется принцип замещения Лисков
	Формулировка: Функции, которые используют ссылки на базовые классы, должны иметь возможность
использовать объекты производных классов, не зная об этом.
	В данном случае используется метод OperatorList.addOperator, которому в качестве одного из аргументов
передается объект типа Computational, но по на самом деле передаются объекты производные от Computational.
*/

package ru.tarasov.solid;

import java.util.ArrayList;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import ru.tarasov.solid.exception.InputException;
import ru.tarasov.solid.exception.NegArgOfSqrtException;
import ru.tarasov.solid.expression.OpInFunc;
import ru.tarasov.solid.expression.Operand;
import ru.tarasov.solid.expression.Operator;
import ru.tarasov.solid.expression.OperatorList;
import ru.tarasov.solid.input.InputString;
import ru.tarasov.solid.valid.IsValid;
import ru.tarasov.solid.valid.RegexValid;

public class CalcProject {
	public static void main(String[] args) {

		// добавление операций в список операторов
		OperatorList opList = new OperatorList();
		opList.addOperator("+", new Summ());
		opList.addOperator("-", new Diff());
		opList.addOperator("*", new Mult());
		opList.addOperator("/", new Div());
		opList.addOperator("sqrt", new Sqrt());
		opList.addOperator("sqr", new Sqr());

		InputString is = new InputString();
		String expression = is.input();

		IsValid valid = new IsValid(expression);
		RegexValid rv = new RegexValid();
		if (valid.SqrIsValid()) {
			try {
				rv.sqrValid(expression);
			} catch (InputException exc) {
				System.out.println(exc);
				return;
			}
			OpInFunc operand = new OpInFunc(expression);
			Operator operator = new Operator(expression, opList);
			int a = operand.get();
			// вызов операции(
			// получает индекс операции в списке операций(извлечение оператора
			// из выражения)
			// )
			System.out.println(opList.getOperation(OperatorList.getIndexToList(operator.getOperator())).comp(a, 0));
		} else if (valid.SqrtIsValid()) {
			try {
				rv.sqrtValid(expression);
			} catch (NegArgOfSqrtException exc) {
				System.out.println(exc);
				return;
			} catch (InputException exc) {
				System.out.println(exc);
				return;
			}
			OpInFunc operand = new OpInFunc(expression);
			Operator operator = new Operator(expression, opList);
			double a = operand.get();
			System.out.println(
					(double) opList.getOperation(OperatorList.getIndexToList(operator.getOperator())).comp(a, 0));
		} else {
			try {
				rv.expValid(expression);
			} catch (InputException exc) {
				System.out.println(exc);
				return;
			}
			Operator operator = new Operator(expression, opList);
			Operand operand = new Operand(expression);
			int a = operand.Partition(1, operator.getIndexOperator());
			int b = operand.Partition(2, operator.getIndexOperator());
			try {
				System.out.println(opList.getOperation(OperatorList.getIndexToList(operator.getOperator())).comp(a, b));
			} catch (ArithmeticException exc) {
				System.out.println("Невозможно выполнить деление на ноль!");
			}
		}
	}
}