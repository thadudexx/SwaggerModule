<?php
/**
 * SwaggerModule
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @copyright  Copyright (c) 2012 OuterEdge UK Ltd (http://www.outeredgeuk.com)
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace SwaggerModule\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * DocumentationController. It is used to display a documentation in HTML
 */
class DocumentationController extends AbstractActionController
{
    /**
     * Display the documentation
     *
     * @return JsonModel
     */
    public function displayAction()
    {
        /** @var $swagger \Swagger\Swagger */
        $swagger = $this->serviceLocator->get('Swagger\Swagger');
        $options = array(
            'prefix' => '/',
            'suffix' => '',
            'basePath' => null,
            'apiVersion' => '1.0.0',
            'swaggerVersion' => '1.2',
            'output' => 'array',
            'json_pretty_print' => true,
        );

        $jsonModel = new JsonModel();

        return $jsonModel->setVariables($swagger->getResourceList($options));
    }

    /**
     * Get the details of a resource
     *
     * @return JsonModel
     */
    public function detailsAction()
    {
        /** @var $swagger \Swagger\Swagger */
        $swagger = $this->serviceLocator->get('Swagger\Swagger');
        $options = array(
            'output' => 'array',
            'json_pretty_print' => true,
            'defaultSwaggerVersion' => '1.2',
        );

        $resource = $swagger->getResource('/' . $this->params('resource', null), $options);

        if ($resource === false) {
            return new JsonModel();
        }

        $jsonModel = new JsonModel();

        return $jsonModel->setVariables($resource);
    }
}
