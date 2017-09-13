package ru.tarasov;

public interface ISearcher{
/*
 * ��������� ���������� ��������� ������ ��� ������������ �������� ������
 * @param classNames �������� ������� � �������
 * @param modificationDates ���� ����������� ������ � ������� ��,
 * ��������� � 1 ������ 1970 ����
*/
	public void refresh(String [] classNames, long [] modificationDates);
	
/*
 * ���� ���������� ����� �������
 * �������� ������ ���������� � start
 * @param start ������ ����� ������
 * @return ������ ����� �� 0 �� 12, ����� �������, ������������� �� ����
 * ����������� � �����������������.
*/
	public String [] guess(String start);
	
}