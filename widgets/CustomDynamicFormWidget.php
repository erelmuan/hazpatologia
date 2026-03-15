<?php
namespace app\widgets;

use kullarkert\dynamicform\DynamicFormWidget;
use Symfony\Component\DomCrawler\Crawler;
use yii\helpers\Html;

class CustomDynamicFormWidget extends DynamicFormWidget
{
  private function getPrivate($name)
    {
        $reflection = new \ReflectionClass(get_parent_class($this));
        $property = $reflection->getProperty($name);
        $property->setAccessible(true);
        return $property->getValue($this);
    }

    private function setPrivate($name, $value)
    {
        $reflection = new \ReflectionClass(get_parent_class($this));
        $property = $reflection->getProperty($name);
        $property->setAccessible(true);
        $property->setValue($this, $value);
    }

    private function callPrivate($method, ...$args)
    {
        $reflection = new \ReflectionClass(get_parent_class($this));
        $m = $reflection->getMethod($method);
        $m->setAccessible(true);
        return $m->invoke($this, ...$args);
    }

    public function run()
    {
        $content = ob_get_clean();
        $crawler = new Crawler();
        $crawler->addHTMLContent('<?xml encoding="UTF-8">' . $content, 'UTF-8');
        $results = $crawler->filter($this->widgetItem);
        $document = new \DOMDocument('1.0', \Yii::$app->charset);
        $document->appendChild($document->importNode($results->first()->getNode(0), true));

        // Accedemos a _options con Reflection
        $options = $this->getPrivate('_options');
        $options['template'] = trim($document->saveHTML());
        $this->setPrivate('_options', $options);

        if (isset($options['min']) && $options['min'] === 0 && $this->model->isNewRecord) {
            $content = $this->callPrivate('removeItems', $content);
        }

        $this->hashOptions();
        $view = $this->getView();
        $widgetRegistered = $this->registerHashVarWidget();

        // Accedemos a _hashVar con Reflection
        $hashVar = $this->getPrivate('_hashVar');
        $this->setPrivate('_hashVar', $this->getHashVarName());
        $hashVar = $this->getPrivate('_hashVar');

        if ($widgetRegistered) {
            $this->registerOptions($view);
            $this->registerAssets($view);
        }

        echo Html::tag('div', $content, ['class' => $this->widgetContainer, 'data-dynamicform' => $hashVar]);
    }
}
