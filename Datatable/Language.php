<?php

/*
 * This file is part of the SgDatatablesBundle package.
 *
 * (c) stwe <https://github.com/stwe/DatatablesBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\DatatablesBundle\Datatable;

use Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Language
 */
class Language
{
    use OptionsTrait;

    /**
     * @var array
     */
    protected $languageCDNFile = [
        'af' => 'af.json',
        'ar' => 'ar.json',
        'az' => 'az.json',
        'be' => 'be.json',
        'bg' => 'bg.json',
        'bn' => 'bn.json',
        'ca' => 'ca.json',
        'cs' => 'cs.json',
        'cy' => 'cy.json',
        'da' => 'da.json',
        'de' => 'de.json',
        'el' => 'el.json',
        'en' => 'en.json',
        'es' => 'es.json',
        'et' => 'et.json',
        'eu' => 'eu.json',
        'fa' => 'fa.json',
        'fi' => 'fi.json',
        'fr' => 'fr.json',
        'ga' => 'ga.json',
        'gl' => 'gl.json',
        'gu' => 'gu.json',
        'he' => 'he.json',
        'hi' => 'hi.json',
        'hr' => 'hr.json',
        'hu' => 'hu.json',
        'hy' => 'hy.json',
        'id' => 'id.json',
        'is' => 'is.json',
        'it' => 'it.json',
        'ja' => 'ja.json',
        'ka' => 'ka.json',
        'ko' => 'ko.json',
        'lt' => 'lt.json',
        'lv' => 'lv.json',
        'mk' => 'mk.json',
        'mn' => 'mn.json',
        'ms' => 'ms.json',
        'nb' => 'nb.json',
        'ne' => 'ne.json',
        'nl' => 'nl.json',
        'nn' => 'nn.json',
        'pl' => 'pl.json',
        'ps' => 'ps.json',
        'pt' => 'pt.json',
        'ro' => 'ro.json',
        'ru' => 'ru.json',
        'si' => 'si.json',
        'sk' => 'sk.json',
        'sl' => 'sl.json',
        'sq' => 'sq.json',
        'sr' => 'sr.json',
        'sv' => 'sv.json',
        'sw' => 'sw.json',
        'ta' => 'ta.json',
        'te' => 'te.json',
        'th' => 'th.json',
        'tr' => 'tr.json',
        'uk' => 'uk.json',
        'ur' => 'ur.json',
        'uz' => 'uz.json',
        'vi' => 'vi.json',
        'zh' => 'zh.json',
    ];

    /**
     * Get the actual language file by app.request.locale from CDN.
     * Default: false.
     *
     * @var bool
     */
    protected $cdnLanguageByLocale;

    /**
     * Get the actual language by app.request.locale.
     * Default: false.
     *
     * @var bool
     */
    protected $languageByLocale;

    /**
     * Set a language by given ISO 639-1 code.
     * Default: null.
     *
     * @var string|null
     */
    protected $language;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->initOptions();
    }

    //-------------------------------------------------
    // Options
    //-------------------------------------------------

    /**
     * @return $this
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'cdn_language_by_locale' => false,
            'language_by_locale'     => false,
            'language'               => null,
        ]);

        $resolver->setAllowedTypes('cdn_language_by_locale', 'bool');
        $resolver->setAllowedTypes('language_by_locale', 'bool');
        $resolver->setAllowedTypes('language', ['null', 'string']);

        return $this;
    }

    //-------------------------------------------------
    // Getters && Setters
    //-------------------------------------------------

    /**
     * @return array
     */
    public function getLanguageCDNFile()
    {
        return $this->languageCDNFile;
    }

    /**
     * @return bool
     */
    public function isCdnLanguageByLocale()
    {
        return $this->cdnLanguageByLocale;
    }

    /**
     * @param bool $cdnLanguageByLocale
     *
     * @return $this
     */
    public function setCdnLanguageByLocale($cdnLanguageByLocale)
    {
        $this->cdnLanguageByLocale = $cdnLanguageByLocale;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLanguageByLocale()
    {
        return $this->languageByLocale;
    }

    /**
     * @param bool $languageByLocale
     *
     * @return $this
     */
    public function setLanguageByLocale($languageByLocale)
    {
        $this->languageByLocale = $languageByLocale;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string|null $language
     *
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }
}
