<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use SerializesModels;

    /**
     * Datos dinámicos para la vista.
     *
     * @var array
     */
    public array $data;

    /**
     * Nombre de la vista/plantilla.
     *
     * @var string
     */
    public string $viewName;

    /**
     * Create a new message instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        
        $plantilla = $data['plantilla'] ?? 'notification-new-pqr';
        $this->viewName = str_starts_with($plantilla, 'emails.') 
            ? $plantilla 
            : 'emails.' . $plantilla;

        if (isset($data['subject'])) {
            $this->subject($data['subject']);
        }
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // $this->viewName renderiza la plantilla deseada
        // $this->data pasa todo el array $data directamente a la vista (disponible como $pqr, $subject, etc.)
        return $this->view($this->viewName, $this->data);
    }
}