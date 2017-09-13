package Heroes;

interface IArcher {
	void ArcherAttack(Hero hero);
}

public class Archer extends Hero implements IArcher {
	public Archer(int health, int power, int armor) {
		super("Archer", health, power, armor);
	}

	public void ArcherAttack(Hero hero) {
		if (this.equals(hero)) {
			System.out.println("Error. The hero can't attack himself.");
			return;
		}
		System.out.println("The " + getName() + " attacks to the " + hero.getName());
		hero.hitting(getPower());
	}
}
