<?php /** @noinspection DuplicatedCode */
/** @noinspection DuplicatedCode */

/*
 * This file is part of the SgDatatablesBundle package.
 *
 * (c) stwe <https://github.com/stwe/DatatablesBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\DatatablesBundle\Datatable\Column;

use Exception;
use Random\RandomException;
use Sg\DatatablesBundle\Datatable\Editable\EditableInterface;
use Sg\DatatablesBundle\Datatable\Filter\TextFilter;
use Sg\DatatablesBundle\Datatable\Helper;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use function count;
use function is_string;

/**
 * Class DateTimeColumn
 */
class DateTimeColumn extends AbstractColumn
{
    use EditableTrait;

    use FilterableTrait;

    /**
     * Moment.js date format.
     * Default: 'lll'.
     *
     * @see http://momentjs.com/
     *
     * @var string
     */
    protected $dateFormat;

    /**
     * Use the time ago format.
     * Default: false.
     *
     * @var bool
     */
    protected $timeago;

    /**
     * Render date through a twig template if the string is not empty.
     * Default: ''.
     *
     * @see https://unicode-org.github.io/icu/userguide/format_parse/datetime/#datetime-format-syntax
     *
     * @var string
     */
    protected $twigDateFormat;

    //-------------------------------------------------
    // ColumnInterface
    //-------------------------------------------------

    /**
     * {@inheritdoc}
     *
     * @throws LoaderError|RuntimeError|SyntaxError|RandomException
     */
    public function renderSingleField(array &$row)
    {
        $path = Helper::getDataPropertyPath($this->data);

        if ($this->accessor->isReadable($row, $path)) {
            if ($this->isEditableContentRequired($row) === true) {
                $content = $this->renderTemplate($this->accessor->getValue($row, $path), $row[$this->editable->getPk()]);
            } else {
                $content = $this->renderTemplate($this->accessor->getValue($row, $path));
            }

            $this->accessor->setValue($row, $path, $content);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws LoaderError|RuntimeError|SyntaxError|RandomException
     */
    public function renderToMany(array &$row)
    {
        $value = null;
        $path  = Helper::getDataPropertyPath($this->data, $value);

        if ($this->accessor->isReadable($row, $path)) {
            $entries = $this->accessor->getValue($row, $path);

            if ($entries !== null && count($entries) > 0) {
                foreach ($entries as $key => $entry) {
                    $currentPath       = $path . '[' . $key . ']' . $value;
                    $currentObjectPath = Helper::getPropertyPathObjectNotation($path, $key, $value);

                    if ($this->isEditableContentRequired($row) === true) {
                        $content = $this->renderTemplate(
                            $this->accessor->getValue($row, $currentPath),
                            $row[$this->editable->getPk()],
                            $currentObjectPath
                        );
                    } else {
                        $content = $this->renderTemplate($this->accessor->getValue($row, $currentPath));
                    }

                    $this->accessor->setValue($row, $currentPath, $content);
                }
            }
            // no placeholder - leave this blank
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCellContentTemplate()
    {
        return '@SgDatatables/render/datetime.html.twig';
    }

    /**
     * {@inheritdoc}
     *
     * @throws LoaderError|RuntimeError|SyntaxError
     */
    public function renderPostCreateDatatableJsContent()
    {
        if ($this->editable instanceof EditableInterface) {
            return $this->twig->render(
                '@SgDatatables/column/column_post_create_dt.js.twig',
                [
                    'column_class_editable_selector' => $this->getColumnClassEditableSelector(),
                    'editable_options'               => $this->editable,
                    'entity_class_name'              => $this->getEntityClassName(),
                    'column_dql'                     => $this->dql,
                    'original_type_of_field'         => $this->getOriginalTypeOfField(),
                ]
            );
        }

        return null;
    }

    //-------------------------------------------------
    // Options
    //-------------------------------------------------

    /**
     * @return $this
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'date_format' => 'lll',
            'timeago'     => false,
            'filter'      => [TextFilter::class, []],
            'editable'    => null,
            'twig_date_format' => '',
        ]);

        $resolver->setAllowedTypes('date_format', 'string');
        $resolver->setAllowedTypes('timeago', 'bool');
        $resolver->setAllowedTypes('filter', 'array');
        $resolver->setAllowedTypes('editable', ['null', 'array']);
        $resolver->setAllowedTypes('twig_date_format', 'string');

        return $this;
    }

    //-------------------------------------------------
    // Getters && Setters
    //-------------------------------------------------

    /**
     * Get date format.
     *
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * Set date format.
     *
     * @param string $dateFormat
     *
     * @return $this
     * @throws Exception
     *
     */
    public function setDateFormat($dateFormat)
    {
        if (empty($dateFormat) || !is_string($dateFormat)) {
            throw new Exception('DateTimeColumn::setDateFormat(): A non-empty string is expected.');
        }

        $this->dateFormat = $dateFormat;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTimeago()
    {
        return $this->timeago;
    }

    /**
     * @param bool $timeago
     *
     * @return $this
     */
    public function setTimeago($timeago)
    {
        $this->timeago = $timeago;

        return $this;
    }

    /**
     * @return string
     */
    public function getTwigDateFormat()
    {
        return $this->twigDateFormat;
    }

    /**
     * @param string $twigDateFormat
     *
     * @return $this
     */
    public function setTwigDateFormat($twigDateFormat)
    {
        $this->twigDateFormat = $twigDateFormat;

        return $this;
    }

    //-------------------------------------------------
    // Helper
    //-------------------------------------------------

    /**
     * Render template.
     *
     * @param string|null $data
     * @param null $pk
     * @param null $path
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws RandomException
     */
    private function renderTemplate($data, $pk = null, $path = null)
    {
        $renderVars = [
            'data'             => $data,
            'default_content'  => $this->getDefaultContent(),
            'date_format'      => $this->dateFormat,
            'timeago'          => $this->timeago,
            'datatable_name'   => $this->getDatatableName(),
            'twig_date_format' => $this->twigDateFormat,
            'row_id'           => Helper::generateUniqueID(),
        ];

        // editable vars
        if ($pk !== null) {
            $renderVars = array_merge($renderVars, [
                'column_class_editable_selector' => $this->getColumnClassEditableSelector(),
                'pk'                             => $pk,
                'path'                           => $path,
            ]);
        }

        return $this->twig->render(
            $this->getCellContentTemplate(),
            $renderVars
        );
    }
}
