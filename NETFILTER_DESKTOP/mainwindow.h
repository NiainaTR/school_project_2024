#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include <QMainWindow>
#include <QLabel>
#include <QPushButton>
#include <QFrame>

QT_BEGIN_NAMESPACE
namespace Ui { class MainWindow; }
QT_END_NAMESPACE

class MainWindow : public QMainWindow
{
    Q_OBJECT

public:
    MainWindow(QWidget *parent = nullptr);
    ~MainWindow();

private slots:
    void on_btnRefresh_clicked();

private:
    Ui::MainWindow *ui;
    void createWidgets(const QString &policy, int rules, QFrame *frame , int nbrChain);
    void onAddRulesButtonClicked(int nbrChain , const QString &policy);
};

#endif // MAINWINDOW_H
