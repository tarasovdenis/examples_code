package Heroes;

public class Hero {
	private String name;
	private int health; // здоровье
	private int armor; // защита
	private int power; // сила атаки

	// create
	public Hero(String name, int health, int power, int armor) {
		this.name = name;
		this.health = health;
		this.armor = armor;
		this.power = power;
	}

	// методы доступа
	protected String getName() {
		return name;
	}

	protected int getPower() {
		return power;
	}

	// поражение
	protected void hitting(int power) {
		// есть защита
		if (armor > 0) {
			armor -= power;
			// защита закончилась
			if (armor < 0) {
				health -= (-armor);
				armor = 0;
			}
			System.out.println(name + " hero was hit.");
			System.out.println("Remaining armor: " + armor);
			System.out.println("Remaining health: " + health);
			System.out.println();
			return;
		}

		// осталось только здоровье
		if (armor == 0 & health >= 0) {
			health -= power;
			// персонаж поражен
			if (health <= 0) {
				System.out.println("Character " + name + " - is dead.\n");
				health = 0;
				return;
			}
			System.out.println(name + " hero was hit.");
			System.out.println("Remaining armor: " + armor);
			System.out.println("Remaining health: " + health);
			System.out.println();
		}

	}

}