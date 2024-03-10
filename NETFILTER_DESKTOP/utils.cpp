#include <stdio.h>
#include <iostream>
#include <stdlib.h>
#include <string>
#include <QString>
#include <QDebug>
#include <vector>


std::vector<std::string> getAllInterfaces() {
    const char command[] = "ifconfig | grep -oE '^[a-zA-Z0-9]+'";

    std::vector<std::string> result;
    FILE* pipe = popen(command, "r");
    if (!pipe) {
        std::cerr << "Erreur lors de l'exécution de la commande." << std::endl;
        return result;
    }
    char *interface = (char *) malloc(100);
    while (!feof(pipe)) {
        if (fgets(interface, 128, pipe) != NULL) {
            interface[strlen(interface) - 1] = '\0';
            result.push_back(interface);
        }
    }
    pclose(pipe);
    free(interface);
    return result;
}



void displayRules(){
    FILE *frInput = NULL;
    FILE *frForward = NULL;
    FILE *frOutput = NULL;
    FILE *frules = NULL;

    frInput = fopen("input.txt" , "r");
    frForward = fopen("forward.txt" , "r");
    frOutput = fopen("output.txt" , "r");
    frules = fopen("rules.txt" , "w");

     if(frInput == NULL || frForward == NULL || frOutput == NULL || frules == NULL){
        exit(1);
    }

    char *target = (char *)malloc(100);
    char *protocol = (char *)malloc(100);
    char *option = (char *)malloc(100);
    char *source =(char *)malloc(100);
    char *destination = (char *)malloc(100);
    char *other = (char *)malloc(100);
    char *line = (char *)malloc(100);


    int num = 0;

    while(fgets(line , 256 , frInput) != NULL){
     //   printf("%s" , result);
        sscanf(line , "%d%s%s%s%s%s    %[^\n]" , &num , target , protocol , option , source , destination , other);
       fprintf(frules , "%d   INPUT   %s  %s  %s  %s  %s  %s\n" , num , target , protocol , option , source , destination , other);
    }
    while(fgets(line , 256 , frForward) != NULL){
       //   printf("%s" , result);
        sscanf(line , "%d%s%s%s%s%s    %[^\n]" , &num ,  target , protocol , option , source , destination , other);
       fprintf(frules , "%d   FORWARD   %s  %s  %s  %s  %s  %s\n" , num , target , protocol , option , source , destination , other);
    }
    while(fgets(line , 256 , frOutput) != NULL){
     //   printf("%s" , result);
        sscanf(line , "%d%s%s%s%s%s    %[^\n]" , &num ,  target , protocol , option , source , destination , other);
       fprintf(frules , "%d   OUTPUT   %s  %s  %s  %s  %s  %s\n" , num , target , protocol , option , source , destination , other);
    }

    fclose(frInput);
    fclose(frForward);
    fclose(frOutput);
    fclose(frules);

    free(target);
    free(protocol);
    free(option);
    free(source);
    free(destination);
    free(other);
    free(line);
}

void getAllRules(){
    FILE *fp1 = NULL;
    FILE *fp2 = NULL;
    FILE *fp3 = NULL;

    FILE *finput = NULL;
    FILE *fforward = NULL;
    FILE *foutput = NULL;
    FILE *frules = NULL;

    char *result = NULL;
    result = (char *)malloc(100 * sizeof(char));

    fp1 = popen("sudo iptables -L INPUT --line-numbers |tail -n +3", "r");
    fp2 = popen("sudo iptables -L FORWARD --line-numbers |tail -n +3", "r");
    fp3 = popen("sudo iptables -L OUTPUT --line-numbers |tail -n +3", "r");

    finput = fopen("input.txt" , "w");
    fforward = fopen("forward.txt" , "w");
    foutput = fopen("output.txt" , "w");
    frules = fopen("rules.txt" , "w");


    if (fp1 == NULL || fp2 == NULL || fp3 == NULL || finput == NULL || fforward == NULL || foutput == NULL || frules == NULL) {
        printf("Erreur lors de l'ouverture du processus.\n");
        exit(1);
    }

    while (fgets(result , sizeof(result)-1, fp1) != NULL) {
        fprintf(finput , "%s" , result);
    }
    while (fgets(result , sizeof(result)-1, fp2) != NULL) {
        fprintf(fforward , "%s" , result);
    }
    while (fgets(result , sizeof(result)-1, fp3) != NULL) {
        fprintf(foutput , "%s" , result);
    }

    pclose(fp1);
    pclose(fp2);
    pclose(fp3);
    pclose(finput);
    pclose(fforward);
    pclose(foutput);

}


QString get_policy(int n)
{
    FILE *fp;
    char result[100];

    if(n == 1) fp = popen("sudo iptables -L INPUT | grep 'Chain' | awk '{print $4}'", "r");
    if(n == 2) fp = popen("sudo iptables -L FORWARD | grep 'Chain' | awk '{print $4}'", "r");
    if(n == 3) fp = popen("sudo iptables -L OUTPUT | grep 'Chain' | awk '{print $4}'", "r");

    std::cout << "hello !!\n";

    if (fp == NULL) {
        printf("Erreur lors de l'ouverture du processus.\n");
        exit(1);
    }

    while (fgets(result , sizeof(result)-1, fp) != NULL) {
        pclose(fp);
        std::string strResult = std::string(result);
        strResult = strResult.substr(0 , strResult.length() - 2);
        qDebug() << "io e :" << QString::fromStdString(strResult);
        return QString::fromStdString(strResult);
    }

    pclose(fp);

    return QString();
}

int get_nbr(int n){
    FILE *fp;
    char result[100];

    if(n == 1) fp = popen("sudo iptables -L INPUT |wc -l", "r");
    if(n == 2) fp = popen("sudo iptables -L FORWARD |wc -l", "r");
    if(n == 3) fp = popen("sudo iptables -L OUTPUT |wc -l", "r");


    if (fp == NULL) {
        printf("Erreur lors de l'ouverture du processus.\n");

        exit(1);
    }
    while (fgets(result , sizeof(result)-1, fp) != NULL) {
        return atoi(result) - 2;
    }

    pclose(fp);


    return 0;
}

