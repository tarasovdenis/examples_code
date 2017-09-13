package ru.tarasov.kmeans;

import java.util.ArrayList;

class Point {
	double x, y;

	Point(double x, double y) {
		this.x = x;
		this.y = y;
	}
}

class Cluster {
	double curX, curY;			//текущие координаты центроида
	double lastX, lastY;		//предыдущие координаты центроида
	ArrayList<Point> vector;	//набор точек

	public Cluster() {
		vector = new ArrayList<>();
	}

	//размер кластера = количество точек
	public int size() {
		return vector.size();
	}

	public void clear() {
		vector.clear();
	}

	//добавление точки в кластер
	public void add(Point p) {
		vector.add(p);
	}

	//вычисление центроида кластера
	public void SetCenter() {
		double sumX = 0, sumY = 0;
		for (int i = 0; i < vector.size(); i++) {
			sumX += vector.get(i).x;
			sumY += vector.get(i).y;
		}

		lastX = curX;
		lastY = curY;
		curX = sumX / vector.size();
		curY = sumY / vector.size();
	}

	public String toString() {
		String result = "";
		for (int i = 0; i < vector.size(); i++) {
			result += "X=" + Double.toString(vector.get(i).x) + ", ";
			result += "Y=" + Double.toString(vector.get(i).y) + "\n";
		}
		return result;
	}
}

class Clustering {
	Cluster[] clusters;	//набор кластеров
	int k;				//количество кластеров

	public Clustering(int k) {
		clusters = new Cluster[k];
		for(int i = 0; i < k; i++)
			clusters[i] = new Cluster();
		this.k = k;
	}

	//инициализация кластеров
	public void InitialClusters(Point [] p) {
		int step = p.length / k;
		for (int i = 0, steper = 0; i < k; i++, steper += step) {
			clusters[i].curX = p[steper].x;
			clusters[i].curY = p[steper].y;
		}
	}

	//распределение точек по кластерам
	//точка распределяется в тот кластер, расстояние до центроида которого меньше
	//чем до центроидов остальных
	public void Bind(Point[] p) {
		int n;

		//каждый кластер очищается
		for (int i = 0; i < k; i++) {
			clusters[i].clear();
		}

		for (int i = 0; i < p.length; i++) {
			//по-умолчанию минимальным расстояние является до первого кластера
			double min = Math.sqrt(Math.pow(clusters[0].curX - p[i].x, 2) + Math.pow(clusters[0].curY - p[i].y, 2));
			n = 0;

			//вычисляется расстояние до других кластеров
			for (int j = 1; j < k; j++) {
				double tmp = Math.sqrt(Math.pow(clusters[j].curX - p[i].x, 2) + Math.pow(clusters[j].curY - p[i].y, 2));

				//если расстояние меньше
				if (tmp < min) {
					min = tmp;
					n = j;
				}
			}

			//точка распределяется в кластер
			clusters[n].add(p[i]);
		}
	}

	public void Start(Point[] p) {
		InitialClusters(p);					//инициализация кластера
		
		//цикл до тех пор, пока на всех кластерах
		//новые координаты не будут равны предыдущим
		while (true) {
			Bind(p);	//распределение точек по кластерам
			
			//поиск новых центров кластеров
			for (int i = 0; i < k; i++) {
				clusters[i].SetCenter();
			}

			//количество кластеров, на которых предыдущие координаты равны новым
			int ch = 0;

			//проверка на совпадение
			for (int i = 0; i < k; i++) {
				if (clusters[i].curX == clusters[i].lastX & clusters[i].curY == clusters[i].lastY)
					++ch;
			}

			//на всех кластерах координаты равны, кластеризация окончена
			if (ch == k)
				return;
		}
	}

	public void Print() {
		for (int i = 0; i < k; i++) {
			System.out.println("Cluster #" + i);
			System.out.println(clusters[i]);
			System.out.println();
		}
	}
}

public class Kmeans {
	public static void main(String[] args) {
		Clustering kmeans = new Clustering(2);
		double [][] arr = {{2.0, 6.0}, {2.0, 2.0}, {6.0, 6.0}, {6.0, 2.0}, {4.0, 4.0}};
		Point[] p = new Point[arr.length];
		for (int i = 0; i < p.length; i++) {
			p[i] = new Point(arr[i][0], arr[i][1]);
		}
		kmeans.Start(p);
		kmeans.Print();
	}
}