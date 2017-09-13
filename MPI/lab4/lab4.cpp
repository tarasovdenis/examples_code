#include <stdio.h>
#include "mpi.h"

int main(int argc, char* argv[]){
	MPI_Init(&argc, &argv);
	int n, size, message;
	MPI_Status status;
	MPI_Comm_rank(MPI_COMM_WORLD, &n);
	MPI_Comm_size(MPI_COMM_WORLD, &size);
	
	message = n;
	if(n == size-1)
		MPI_Send(&message, 1, MPI_INT, 0, 0, MPI_COMM_WORLD);
	else
		MPI_Send(&message, 1, MPI_INT, n+1, 0, MPI_COMM_WORLD);

	if(n == 0)
		MPI_Recv(&message, 1, MPI_INT, size-1, MPI_ANY_TAG, MPI_COMM_WORLD, &status);
	else
		MPI_Recv(&message, 1, MPI_INT, n-1, MPI_ANY_TAG, MPI_COMM_WORLD, &status);
	
	printf("[%d] receive message: %d\n", n, message);

	MPI_Finalize();

	return 0;
}