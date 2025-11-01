import '../css/app.css';
import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import SidebarProvider from './Pages/Context/SidebarContext';
import Layot from './Pages/components/Layout/Layot';
import Expelor from './Pages/components/template/Expelor';

const pages = import.meta.glob('./Pages/**/*.jsx');

createInertiaApp({
    resolve: async (name) => {
        const page = await pages[`./Pages/${name}.jsx`]();
        const Component = page.default;

        Component.layout = Component.layout || ((page) =>
            <SidebarProvider>
                <Layot>
                    <main className='max-w-[1440px]  md:mx-auto'>
                        {page}
                        <Expelor />
                    </main>
                </Layot>
            </SidebarProvider>
        );

        return Component;
    },
    setup({ el, App, props }) {
        createRoot(el).render(
            <App {...props} />
        );
    },
});
