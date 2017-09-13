/*Лабораторная работа. Взаимодействие объектов.*/

import Heroes.Archer;
import Heroes.Swordsman;
import Heroes.Wizard;

public class lab2 {
	public static void main(String[] args) {
		Archer a = new Archer(100, 25, 100);
		Wizard w = new Wizard(100, 20, 60);
		Swordsman s = new Swordsman(100, 4, 80);

		a.ArcherAttack(w);
		w.WizardAttack(a);
		w.WizardAttack(s);
		s.SwordsmanAttack(a);
		s.SwordsmanAttack(w);
		s.SwordsmanAttack(w);
		s.SwordsmanAttack(w);
		a.ArcherAttack(w);
		a.ArcherAttack(w);
		a.ArcherAttack(w);
		a.ArcherAttack(w);
		a.ArcherAttack(w);
		
		System.out.println(a.getClass());
	}
}
