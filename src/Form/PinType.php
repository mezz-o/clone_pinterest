<?php

namespace App\Form;

use App\Entity\Pin;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image (JPG or PNG file)',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Delete',
                'download_label' => 'Download',
                'download_uri' => false,
                'imagine_pattern' => 'square_thumbnail_small'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pin::class,
        ]);
    }
}
