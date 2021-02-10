<?php

namespace Vegamail\Request;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * PostMessageDefinition
 *
 * @author Jonathan Martin <jonathan@hadoken.io>
 */
class PostSendDefinition extends AbstractRequestDefinition
{
    public function getMethod()
    {
        return 'POST';
    }

    public function getBaseUrl()
    {
        return '/send';
    }

    public function getBody()
    {
        $options = $this->getOptions();
        return array_filter([
            'template' => $options['template'],
            'data' => $options['data'],
            'to' => is_array($options['to']) ? $options['to'] : [$options['to']],
            'cc' => $options['cc'] ?? null,
            'bcc' => $options['bcc'] ?? null,
            'tags' => $options['tags'] ?? null,
        ]);
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined([
            'template',
            'to',
            'data',
            'cc',
            'bcc',
            'tags'
        ]);
        $resolver->setRequired(['template', 'to']);
        $resolver->setAllowedTypes('to', ['string', 'array']);
        $resolver->setAllowedTypes('cc', ['array']);
        $resolver->setAllowedTypes('bcc', ['array']);
        $resolver->setAllowedTypes('data', ['array']);
        $resolver->setAllowedTypes('tags', ['array']);
    }
}
