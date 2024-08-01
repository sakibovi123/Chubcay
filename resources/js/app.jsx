import './bootstrap';
import '../css/app.css';

import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Header from './Components/Main/Header';

const appName = import.meta.env.VITE_APP_NAME || 'Chubcay';

createInertiaApp({
    title: (title) => `${title} ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);

    root.render(
        <div>
            {/* <Header /> */}
            {/* <Header id="header"> */}
                <App {...props} />
            {/* </Header> */}
            
        </div>
        
    );
    },
    progress: {
        color: '#4B5563',
    },
});
