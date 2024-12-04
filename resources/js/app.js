import './bootstrap';
import Echo from 'laravel-echo';
import Reverb from 'reverb-client';

window.Reverb = Reverb;

window.echo = new Echo({
    broadcaster: 'reverb',
    key: process.env.MIX_REVERB_KEY,
    secret: process.env.MIX_REVERB_SECRET,
    app_id: process.env.MIX_REVERB_APP_ID,
    cluster: process.env.MIX_REVERB_CLUSTER,
    encrypted: true,
});

Echo.channel('overdue-equipment')
    .listen('OverdueEquipmentEvent', (event) => {
        console.log('Received overdue equipment event:', event);
        // Handle the event (e.g., show a notification or update UI)
    });
