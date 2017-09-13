#include <mpi.h>

int main(int argc, char *argv[]){
	int n, rank;
	int buf;
	MPI_Request request;
	MPI_Status status;
	MPI_Init(&argc, &argv);

	MPI_Comm_rank(MPI_COMM_WORLD, &rank);
	MPI_Comm_size(MPI_COMM_WORLD, &n);

	if(rank == 0){
		for(int i = 0; i < n-1; i++){
			MPI_Irecv(&buf, 1, MPI_INT, MPI_ANY_SOURCE, MPI_ANY_TAG, MPI_COMM_WORLD, &request);
			MPI_Wait(&request, &status);
			printf("Процесс 0 получил сообщение: %d\n", buf);
		}
	}
	else{
		buf = 45;
		MPI_Isend(&buf, 1, MPI_INT, 0, 0, MPI_COMM_WORLD, &request);
		MPI_Wait(&request, &status);
		printf("Процесс %d доставил сообщение\n", rank);
	}

	MPI_Finalize();

	return 0;
}