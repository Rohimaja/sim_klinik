// import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { type MainNavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { LayoutGrid, Database, ClipboardPlus} from 'lucide-react';
import AppLogo from './app-logo';

const mainNavItems: MainNavItem[] = [
    {
        title: 'Dashboard',
        icon: LayoutGrid,
        href: '/dashboard',
    },
    {
        title: 'Master Data',
        icon: Database,
        subItems: [
            {
                title: 'Petugas',
                href: '/MasterData/petugas',
            },
            {
                title: 'Perawat',
                href: '/MasterData/perawat',
            },
            {
                title: 'Pasien',
                href: '/MasterData/Pasien',
            },
            {
                title: 'Dokter',
                href: '/MasterData/dokter',
            },
            {
                title: 'Jadwal',
                href: '/MasterData/jadwal',
            },
            {
                title: 'Poli',
                href: '/MasterData/Poli',
            },
            {
                title: 'Obat',
                href: '/MasterData/Obat',
            },
            {
                title: 'Alat Kesehatan',
                href: '/MasterData/Alat Kesehatan',
            },
        ]
    },
    {
        title: 'Laporan',
        icon: ClipboardPlus,
        subItems: [
            {
                title: 'Kunjungan Pasien',
                href: '/MasterData/kunjunganPasien',
            },
            {
                title: 'Pendapatan Harian',
                href: '/MasterData/pendapatanHarian',
            },
            {
                title: 'Stok Obat',
                href: '/MasterData/stokObat',
            },
        ]
    },
]

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboard()} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
