#include <stdio.h>
#include <stdlib.h>

int main() {
    FILE * fp;
    char * line = NULL;
    size_t len = 0;
    size_t read;
    int32_t result = 0;
    int lines[200];
    fp = fopen("input.txt", "r");
    if (fp == NULL)
        exit(EXIT_FAILURE);

    int i = 0;
    while ((read = getline(&line, &len, fp)) != -1) {
        lines[i] = atoi(line);
        i++;
    }

    for(int k = 0; k<i; k++){
        for(int j = 0; j<i; j++){
            if(lines[j] + lines[k] == 2020){
                printf("res %d", lines[j] * lines[k]);
            }
        }
    }
    fclose(fp);
    return 0;
}
