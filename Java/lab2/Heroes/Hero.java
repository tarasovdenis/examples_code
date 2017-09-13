package Heroes;

public class Hero {
	private String name;
	private int health; // ��������
	private int armor; // ������
	private int power; // ���� �����

	// create
	public Hero(String name, int health, int power, int armor) {
		this.name = name;
		this.health = health;
		this.armor = armor;
		this.power = power;
	}

	// ������ �������
	protected String getName() {
		return name;
	}

	protected int getPower() {
		return power;
	}

	// ���������
	protected void hitting(int power) {
		// ���� ������
		if (armor > 0) {
			armor -= power;
			// ������ �����������
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

		// �������� ������ ��������
		if (armor == 0 & health >= 0) {
			health -= power;
			// �������� �������
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