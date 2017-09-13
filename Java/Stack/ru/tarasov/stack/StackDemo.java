/*
	Стек.
	Организация стека с помощью массива.
*/

package ru.tarasov.stack;

class Stack{
	private int MAXSIZE;	//максимальный размер стека
	private boolean Empty;			//признак "стек пуст"
	private boolean OverFlow;		//индикатор переполнения стека
	private int head;				//указатель на вершину стека
	private int [] arr;				//массив для хранения стека
	
	//true - если стек пуст
	public boolean IsEmpty(){
		return Empty;
	}
	
	//true - если стек заполнен
	public boolean StackOverFlow(){
		return OverFlow;
	}
	
	public Stack(int size){
		head = -1;
		MAXSIZE = size;
		OverFlow = false;
		Empty  = true;
		arr = new int [size];
	}
	
	//вставка нового элемента
	public void Push(int elem){
		try{
			if(head >= MAXSIZE-1)
				throw new ArrayIndexOutOfBoundsException();
			arr[++head] = elem;
			System.out.println("push(" + elem + ")");
		}
		catch(ArrayIndexOutOfBoundsException exc){
			System.out.println("stack overflow.");
			OverFlow = true;
		}
		finally{
			Empty = false;
		}
}
	
	//извлечь элемент из стека
	public int Pop(){
		int elem = -1;
		try{
			elem = arr[head--];
			OverFlow = false;
			if(head < 0)
				throw new ArrayIndexOutOfBoundsException();
		}catch(ArrayIndexOutOfBoundsException exc){
			Empty = true;
		}
		
		return elem;
	}
	
	//извлечение и печать элемента из стека
	public void print(){
		try{
			if(IsEmpty())
				throw new NullPointerException();
			System.out.println(Pop());
		}
		catch(NullPointerException exc){
			System.out.println("stack is empty");
		}
	}
	
	//размер стека
	public int size(){
		return MAXSIZE;
	}
	
	public String toString(){
		String result = "";
		while(!IsEmpty()){
			result += Pop() + ",";
		}
		return result;
	}
}

class StackDemo{
	public static void main(String [] args){
		Stack s = new Stack(20);
		for(int i = 0; i < s.size() + 3; i++)
			s.Push(i);
		
		System.out.println(s);
	}
}