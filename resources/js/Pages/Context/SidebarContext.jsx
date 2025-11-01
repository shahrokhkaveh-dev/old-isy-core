import { createContext, useContext, useState } from "react";

const SidebarContext = createContext()

export default function SidebarProvider({ children }) {

    const [filterOpen, setFilterOpen] = useState(false)
    const [Sidebar, setSidebar] = useState(false)

    const toggleFilter = () => setFilterOpen(prev => !prev);
    const toggleSidebar = () => setSidebar(prev => !prev);

    return (
        <SidebarContext.Provider value={{ filterOpen, toggleFilter, toggleSidebar, Sidebar }}>
            {children}
        </SidebarContext.Provider>
    );
}

export const useSidebar = () => useContext(SidebarContext)
