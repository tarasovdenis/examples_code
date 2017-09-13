package Heroes;

interface ISwordsman {
	void SwordsmanAttack(Hero hero);
}

public class Swordsman extends Hero implements ISwordsman {
	public Swordsman(int health, int power, int armor) {
		super("Wizard", health, power, armor);
	}

	public void SwordsmanAttack(Hero hero) {
		if (this.equals(hero)) {
			System.out.println("Error. The hero can't attack himself.");
			return;
		}
		System.out.println("The " + getName() + " attacks to the " + hero.getName());
		hero.hitting(getPower());
	}
}