#include <stdio.h>
#include "mpi.h"

int main(int argc, char *argv[]){
	int rank, n;
	MPI_Init(&argc, &argv);
	MPI_Comm_size(MPI_COMM_WORLD, &n);
	MPI_Comm_rank(MPI_COMM_WORLD, &rank);
	MPI_Finalize();
		printf("I am %d process from %d processes!\n", rank, n);

	return 0;
}