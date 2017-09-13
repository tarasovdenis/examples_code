package Heroes;

interface IWizard {
	void WizardAttack(Hero hero);
}

public class Wizard extends Hero implements IWizard {
	public Wizard(int health, int power, int armor) {
		super("Wizard", health, power, armor);
	}

	public void WizardAttack(Hero hero) {
		if (this.equals(hero)) {
			System.out.println("Error. The hero can't attack himself.");
			return;
		}
		System.out.println("The " + getName() + " attacks to the " + hero.getName());
		hero.hitting(getPower());
	}
}