<?php
 
namespace AppBundle\Services;
 
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
 
class SaveFileHandler
{
    protected $container;
    public function __construct( ContainerInterface $container)
    {
        $this->container = $container;
    }
 
    public function save( $fileObject , $path)
    {
 
        $dir = $this->container->get('kernel')->getRootDir() . '/../web/' . $path;
 
        $sub_path = md5( $fileObject->getClientOriginalName() . microtime() );
 
        $dir .= '/' . $sub_path . '/';
        $fs = new Filesystem();
 
        if( !$fs->exists( $dir ) )
        {
            try {
                $fs->mkdir( $dir );
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating your directory at ".$e->getPath();
            }
        }
 
        $file = str_replace( 'image/' , mt_rand(1,99) .'.' , $fileObject->getMimeType() );
 
        $fileObject->move( $dir , $file );
 
        return '/'.$path.'/' . $sub_path . '/' . $file;
    }
 
    public function remove( $file)
    {
        $fs = new Filesystem();
        $full_path =  $this->container->get('kernel')->getRootDir() . '/../' . $file ;
 
        $full_path = preg_replace('/\/\d+\.\w+$/' , '' , $full_path);
 
 
        if( $fs->exists( $full_path) )
        {
 
            try {
                $fs->remove( $full_path );
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating your directory at ".$e->getPath();
            }
        }
 
    }
}