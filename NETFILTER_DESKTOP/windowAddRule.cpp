#include "windowAddRule.h"

#include <QGuiApplication>
#include <QScreen>

WindowAddRule::WindowAddRule(QWidget *parent) : QMainWindow(parent)
{
    // Obtenir la géométrie de la fenêtre principale
    QRect mainScreenGeometry = QGuiApplication::primaryScreen()->geometry();

    // Calculer la position centrale pour la nouvelle fenêtre
    int newX = mainScreenGeometry.width() / 2 - this->width() / 2;
    int newY = mainScreenGeometry.height() / 2 - this->height() / 2;

    // Définir la position de la fenêtre au centre de la fenêtre principale
    this->move(newX, newY);
}
