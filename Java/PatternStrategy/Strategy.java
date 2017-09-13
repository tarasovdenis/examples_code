import java.util.ArrayList;
import java.util.Iterator;

//отчет
abstract class Statement {
	
	public String GetValue(Customer customer) {
		String result = GetHeader(customer);
		for (Rental rental : customer.iterator()) {
			result += GetRentalString(rental);
		}
		result += GetFooter(customer);
		return result;
	}

	protected abstract String GetFooter(Customer customer);

	protected abstract String GetRentalString(Rental rental);

	protected abstract String GetHeader(Customer customer);

}

// арендатор
class Customer {
	
	public String GetStatementValue(Statement statement){
		return statement.GetValue(this);
	}
	
	private ArrayList<Rental> rentals = new ArrayList<>();

	public ArrayList<Rental> iterator() {
		return rentals;
	}
	
	public void SetRental(String MovieName, String Charge){
		Rental tmp = new Rental(MovieName, Charge);
		rentals.add(tmp);
	}

	private String Name;
	
	public void SetName(String Name){
		this.Name = Name;
	}
	
	public String GetName(){
		return Name;
	}

	//получить всю цену
	public String GetTotalCharge() {
		String result = "";
		int tmp = 0;
		for(Rental r : rentals){
			Integer i = new Integer(r.GetCharge());
			tmp += i;
		}
		return Integer.toString(tmp);
	}
	
	//получение количества очков
	public String GetTotalFrequentRenterPoints(){
		Double tmp = new Double(GetTotalCharge());
		tmp *= 0.1;
		return tmp.toString();
	}
}

//аренда
class Rental{
	private String MovieName;
	private String Charge;
	
	public Rental(String MovieName, String Charge){
		this.MovieName = MovieName;
		this.Charge = Charge;
	}
	
	public String GetMovieName(){
		return MovieName;
	}
	
	public String GetCharge(){
		return Charge;
	}
}

class TextStatement extends Statement{

	@Override
	protected String GetFooter(Customer customer) {
		return "Учет аренды для " + customer.GetName() + "\n";
	}

	@Override
	protected String GetRentalString(Rental rental) {
		return "\t" + rental.GetMovieName() + "\t" + 
					rental.GetCharge() + "\n";
	}

	@Override
	protected String GetHeader(Customer customer) {
		return "Сумма задолжности составляет " + 
					customer.GetTotalCharge() + "\n" +
				"Вы заработали " + customer.GetTotalFrequentRenterPoints() + 
				" очков за активность";
	}
	
}

class HTMLStatement extends Statement{

	@Override
	protected String GetFooter(Customer customer) {
		return "<H1>Учет аренды для <EM>" + customer.GetName() + "</EM></H1><P>";
	}

	@Override
	protected String GetRentalString(Rental rental) {
		return rental.GetMovieName() + "    " + rental.GetCharge() + "<BR>";
	}

	@Override
	protected String GetHeader(Customer customer) {
		return "<P>Сумма задолженности составляет <EM>" +
				customer.GetTotalCharge() + "</EM><BR></P>" +
				"Вы заработали <EM> " + customer.GetTotalFrequentRenterPoints() +
				"</EM> очков за активность";
	}
}

class Context{
	Statement statement;
	
	Context(Statement statement){
		this.statement = statement;
	}
	
	
}

public class Strategy {
	public static void main(String [] args){
		HTMLStatement st1 = new HTMLStatement();
		TextStatement st2 = new TextStatement();
		
		Customer customer1 = new Customer();
		customer1.SetName("OneCustomer");
		customer1.SetRental("OneMovie", "100");
		customer1.SetRental("TwoMovie", "200");
		customer1.SetRental("ThreeMovie", "300");
		customer1.SetRental("FourMovie", "400");
		System.out.println(customer1.GetStatementValue(st1));
		
		System.out.println("\n");
		
		Customer customer2 = new Customer();
		customer2.SetName("TwoCustomer");
		customer2.SetRental("OneSerial", "500");
		customer2.SetRental("TwoSerial", "600");
		customer2.SetRental("ThreeSerial", "700");
		customer2.SetRental("FourSerial", "800");
		System.out.println(customer2.GetStatementValue(st2));
	}
}
