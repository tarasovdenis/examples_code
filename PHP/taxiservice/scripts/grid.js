function Field(id, fio, email, departure, destination, car, status){
    this.id = id;
    this.fio = fio;
    this.email = email;
    this.departure = departure;
    this.destination = destination;
    this.car = car;
    this.status = status;
    
    this.tr = document.createElement('tr');
    this.s = document.createElement('td');
    this.s.innerHTML = status;
    this.tr.appendChild(this.s);
    
    this.b = document.createElement('td'); 
    this.btn = document.createElement('button');
    this.btn.setAttribute('type', 'button');
    this.btn.innerHTML = "Подтвердить";
    
    this.b.appendChild(this.btn);
    this.tr.appendChild(this.b);
    
}