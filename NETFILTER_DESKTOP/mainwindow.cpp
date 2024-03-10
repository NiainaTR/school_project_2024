#include "mainwindow.h"
#include "ui_mainwindow.h"
#include "utils.h"
#include <QDebug>
#include <QVBoxLayout>
#include <QLineEdit>
#include <QComboBox>
#include <qcombobox.h>
#include <QRadioButton>
#include <QButtonGroup>
#include <QCheckBox>
#include <QProcess>
#include <QMessageBox>

MainWindow::MainWindow(QWidget *parent) :
    QMainWindow(parent),
    ui(new Ui::MainWindow)
{
    ui->setupUi(this);

    createWidgets(get_policy(1), get_nbr(1), ui->inputFrame , 1);
    createWidgets(get_policy(2), get_nbr(2), ui->forwardFrame , 2);
    createWidgets(get_policy(3), get_nbr(3), ui->outputFrame , 3);

    //displayRules();
    //getAllRules();
}

MainWindow::~MainWindow()
{
    delete ui;
}


void connectCheckBoxToVisibility(QCheckBox *checkBox , QWidget *widget , QVBoxLayout *layout){
    auto updateTextInputVisibility = [=](int state) {
        if (state == Qt::Checked) {
            widget->setVisible(true);
        } else {
            widget->setVisible(false);
        }
    };

    QObject::connect(checkBox , &QCheckBox::stateChanged, updateTextInputVisibility);

    layout->addWidget(widget);

}



void MainWindow::onAddRulesButtonClicked(int nbrChain , const QString &policy){
    QMainWindow *windowAddRule = new QMainWindow();
    windowAddRule->setFixedSize(300, 400);


    QWidget *centralWidget = new QWidget();
    windowAddRule->setCentralWidget(centralWidget);

    QVBoxLayout *layout = new QVBoxLayout();
    centralWidget->setLayout(layout);

    QString chain = "";

    if(nbrChain == 1) chain = "INPUT";
    if(nbrChain == 2) chain = "FORWARD";
    if(nbrChain == 3) chain = "OUTPUT";

    QLabel *titleAddRule = new QLabel("ADD RULE");
    layout->addWidget(titleAddRule);

    QLabel *chainLabel = new QLabel("CHAIN : " + chain);
    layout->addWidget(chainLabel);

    QLabel *defaultPolicyLabel = new QLabel("DEFAULT POLICY : ");
    layout->addWidget(defaultPolicyLabel);

    QComboBox *defaultPolicySelect = new QComboBox();
    defaultPolicySelect->addItem("ACCEPT");
    defaultPolicySelect->addItem("DROP");
    defaultPolicySelect->addItem("REJECT");
    int index = defaultPolicySelect->findText(policy);
    defaultPolicySelect->setCurrentIndex(index);
    layout->addWidget(defaultPolicySelect);


    QCheckBox *checkBoxProtocol = new QCheckBox("PROTOCOLES");
    layout->addWidget(checkBoxProtocol);

    QComboBox *protocoles = new  QComboBox();
    protocoles->addItem("all");
    protocoles->addItem("tcp");
    protocoles->addItem("udp");
    protocoles->addItem("icmp");
    protocoles->setVisible(false);

    connectCheckBoxToVisibility(checkBoxProtocol , protocoles , layout);


    QCheckBox *checkBoxMatch = new QCheckBox("MATCH");
    layout->addWidget(checkBoxMatch);

    QCheckBox *checkBoxMac = new QCheckBox("MAC");
    checkBoxMac->setVisible(false);
    connectCheckBoxToVisibility(checkBoxMatch , checkBoxMac , layout);


    QLineEdit *inputMac = new QLineEdit();
    inputMac->setVisible(false);
    connectCheckBoxToVisibility(checkBoxMac , inputMac , layout);


    QCheckBox *checkBoxMultiport = new QCheckBox("MULTIPORT");
    checkBoxMultiport->setVisible(false);
    connectCheckBoxToVisibility(checkBoxMatch , checkBoxMultiport , layout);

    QCheckBox *checkBoxPortDest = new QCheckBox("Port Destination");
    checkBoxPortDest->setVisible(false);
    connectCheckBoxToVisibility(checkBoxMultiport , checkBoxPortDest , layout);

    QLineEdit *inputDports = new QLineEdit();
    inputDports->setVisible(false);
    connectCheckBoxToVisibility(checkBoxPortDest , inputDports , layout);

    QCheckBox *checkBoxPortSource = new QCheckBox("Port Source");
    checkBoxPortSource->setVisible(false);
    connectCheckBoxToVisibility(checkBoxMultiport , checkBoxPortSource , layout);

    QLineEdit *inputSports = new QLineEdit();
    inputSports->setVisible(false);
    connectCheckBoxToVisibility(checkBoxPortSource , inputSports , layout);

    QCheckBox *checkBoxDestination = new QCheckBox("DESTINATION");
    layout->addWidget(checkBoxDestination);

    QLineEdit *inputDestination = new QLineEdit();
    inputDestination->setVisible(false);
    connectCheckBoxToVisibility(checkBoxDestination , inputDestination , layout);

    QCheckBox *checkBoxSource = new QCheckBox("SOURCE");
    layout->addWidget(checkBoxSource);

    QLineEdit *inputSource = new QLineEdit();
    inputSource->setVisible(false);
    connectCheckBoxToVisibility(checkBoxSource , inputSource , layout);

    QCheckBox *checkBoxOutputInterface = new QCheckBox("OUTPUT INTERFACE");
    layout->addWidget(checkBoxOutputInterface);

    QComboBox *listOutputInterface = new QComboBox();
    std::vector<std::string> allInterfaces = getAllInterfaces();

    for(auto interface : allInterfaces){
        listOutputInterface->addItem(QString::fromStdString(interface));
    }
    listOutputInterface->setVisible(false);
    connectCheckBoxToVisibility(checkBoxOutputInterface , listOutputInterface , layout);

    QCheckBox *checkBoxInputInterface = new QCheckBox("INPUT INTERFACE");
    layout->addWidget(checkBoxInputInterface);

    QComboBox *listInputInterface = new QComboBox();
    for(auto interface : allInterfaces){
        listInputInterface->addItem(QString::fromStdString(interface));
    }
    listInputInterface->setVisible(false);
    connectCheckBoxToVisibility(checkBoxInputInterface , listInputInterface , layout);

    QLabel *target = new QLabel("TARGET : ");
    layout->addWidget(target);

    QComboBox *listTarget = new QComboBox();
    listTarget->addItem("ACCEPT");
    listTarget->addItem("DROP");
    listTarget->addItem("REJECT");
    layout->addWidget(listTarget);


    QPushButton *btnAddSubmit = new QPushButton("SUBMIT");
    layout->addWidget(btnAddSubmit);

    QObject::connect(btnAddSubmit , &QPushButton::clicked , [=](){
        QProcess process1;

        QString cmd = "";

        //QString selectedText = comboxBox->currentText()
        //bool isCheck = checkbox->isChecked
        //QString enteredText = lineEdit->text();

        cmd = "sudo iptables -P " + chain + " " + defaultPolicySelect->currentText();

        FILE* pipe = popen(cmd.toUtf8().constData() , "r");
        if (!pipe) {
            qDebug() << "Erreur lors de l'exécution de la commande.\n";
        }

        fclose(pipe);

        cmd = "";

        if(checkBoxProtocol->isChecked()){
            cmd = "sudo iptables -A "+chain+" -p "+protocoles->currentText();
        }



        if(checkBoxMatch->isChecked()){
            if(checkBoxMac->isChecked() && !inputMac->text().isEmpty()){
                cmd = cmd+" -m mac --mac-source "+inputMac->text();
            }

            if(checkBoxMultiport->isChecked() && checkBoxPortDest->isChecked() && !inputDports->text().isEmpty()){
                cmd = cmd+" -m multiport --dports "+inputDports->text();
            }
            if(checkBoxMultiport->isChecked() && checkBoxPortSource->isChecked() && !inputSports->text().isEmpty()){
                 cmd = cmd+" -m multiport --sports "+inputSports->text();
            }
        }

        if(checkBoxDestination->isChecked() && !inputDestination->text().isEmpty()){
            cmd = cmd+" -d "+inputDestination->text();
        }

        if(checkBoxSource->isChecked() && !inputSource->text().isEmpty()){
            cmd = cmd+" -s "+inputSource->text();
        }

        if(checkBoxOutputInterface->isChecked()){
            cmd = cmd+" -o "+listOutputInterface->currentText();
        }

        if(checkBoxInputInterface->isChecked()){
            cmd = cmd+" -i "+listInputInterface->currentText();
        }

        if(checkBoxProtocol->isChecked() ||
           checkBoxMatch->isChecked() ||
           checkBoxMultiport->isChecked() ||
           checkBoxDestination->isChecked() ||
           checkBoxSource->isChecked() ||
            checkBoxInputInterface->isChecked() ||
            checkBoxOutputInterface->isChecked()
           ){
            cmd = cmd+" -j "+listTarget->currentText()+" 2> error.txt";
        }
        else{
            cmd = cmd+" 2> error.txt";
        }


        FILE* p = popen(cmd.toUtf8().constData() , "r");
        if (!p) {
            qDebug() << "Erreur lors de l'exécution de la commande.\n";
        }

        fclose(p);



        FILE *pf = fopen("error.txt" , "r");
        char *line = (char *)malloc(100);
        if(pf != NULL){
            while(fgets(line , 100 , pf) != NULL){
                if(line){
                    QMessageBox::critical(nullptr, "Erreur", line);
                    break;
                }
            }
        }



        free(line);

        qDebug() << cmd << "\n";




    });

    windowAddRule->show();
}



void MainWindow::createWidgets(const QString &policy, int rules, QFrame *frame , int nbrChain)
{
    QLabel *policyLabel = new QLabel("Policy : " + policy, frame);
    QLabel *rulesLabel = new QLabel("Rules : " + QString::number(rules), frame);
    QPushButton *addRulesButton = new QPushButton("ADD RULES", frame);

    policyLabel->setGeometry(30, 60, 121, 17);
    rulesLabel->setGeometry(30, 80, 121, 17);
    addRulesButton->setGeometry(40, 110, 111, 41);
    addRulesButton->setStyleSheet("QPushButton {"
                                    "background-color:transparent;"
                                    "border:1px solid #000;"
                                  "}"
                                 );

    QObject::connect(addRulesButton, &QPushButton::clicked, [=]() {
        // Code à exécuter lorsque le bouton est cliqué
        onAddRulesButtonClicked(nbrChain , policy);
    });

    policyLabel->show();
    rulesLabel->show();
    addRulesButton->show();
}



void MainWindow::on_btnRefresh_clicked()
{
    createWidgets(get_policy(1), get_nbr(1), ui->inputFrame , 1);
    createWidgets(get_policy(2), get_nbr(2), ui->forwardFrame , 2);
    createWidgets(get_policy(3), get_nbr(3), ui->outputFrame , 3);
}

