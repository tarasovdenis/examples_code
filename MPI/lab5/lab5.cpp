#include <stdio.h>
#include "mpi.h"

int main(int argc, char *argv[]){
	int n, rank, message;
	MPI_Status status;

	MPI_Init(&argc, &argv);
	MPI_Comm_rank(MPI_COMM_WORLD, &rank);
	MPI_Comm_size(MPI_COMM_WORLD, &n);

	if(rank == 0){
		for(int i = 1; i < n; i++){
			MPI_Recv(&message, 1, MPI_INT, i, MPI_ANY_TAG, MPI_COMM_WORLD, &status);
			printf("receivemessage %d from %d\n", message, i);
		}
	}
	else
	{
		MPI_Send(&rank, 1, MPI_INT, 0, 0, MPI_COMM_WORLD);
	}

	MPI_Finalize();
	return 0;
}