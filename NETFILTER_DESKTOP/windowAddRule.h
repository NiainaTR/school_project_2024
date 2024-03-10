#ifndef WINDOWADDRULE_H
#define WINDOWADDRULE_H

#include <QMainWindow>
#include <QLabel>

class WindowAddRule : public QMainWindow
{
    Q_OBJECT

public:
    explicit WindowAddRule(QWidget *parent = nullptr);

    // Méthode pour définir les informations dans les QLabel
    void setInformation(int nbrChain, const QString &policy);

private:
    QLabel *label1;
    QLabel *label2;
};


#endif // WINDOWADDRULE_H
