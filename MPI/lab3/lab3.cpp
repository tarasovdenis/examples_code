#include <stdio.h>
#include "mpi.h"

int main(int argc, char* argv[]){
	MPI_Init(&argc, &argv);
	int n, message;
	MPI_Status status;
	MPI_Comm_rank(MPI_COMM_WORLD, &n);
	if(n == 0){
		message = 45;
		MPI_Send(&message, 1, MPI_INT, 1, 0, MPI_COMM_WORLD);
	}
	else{
		MPI_Recv(&message, 1, MPI_INT, 0, 0, MPI_COMM_WORLD, &status);
		printf("receive message \'%d\'", message);
	}
	MPI_Finalize();
	return 0;
}