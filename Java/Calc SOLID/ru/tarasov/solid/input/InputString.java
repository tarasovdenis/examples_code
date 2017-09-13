package ru.tarasov.solid.input;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;

//ввод выражения
public class InputString implements InterfaceInputString{
	private String str = new String();
	
	@Override
	public String input(){
		BufferedReader br = new BufferedReader(new InputStreamReader(System.in));
		try{
			str = br.readLine();
		}catch(IOException exc){
			System.out.println("InputString : input(): " + exc);
		}
		return str;
	}
	
}
