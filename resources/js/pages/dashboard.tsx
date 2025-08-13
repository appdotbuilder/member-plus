import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { AppContent } from '@/components/app-content';
import { AppHeader } from '@/components/app-header';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { type BreadcrumbItem } from '@/types';

interface InsurancePolicy {
    id: number;
    policy_number: string;
    name: string;
    type: string;
    status: string;
    premium_amount: number;
    coverage_amount: number;
    start_date: string;
    end_date: string;
    formatted_premium: string;
    formatted_coverage: string;
}

interface InsuranceClaim {
    id: number;
    claim_number: string;
    title: string;
    status: string;
    claimed_amount: number;
    formatted_claimed_amount: string;
    status_color: string;
    insurance_policy: {
        name: string;
        type: string;
    };
    created_at: string;
}

interface DentalAppointment {
    id: number;
    appointment_number: string;
    service_type: string;
    appointment_datetime: string;
    formatted_date_time: string;
    clinic_name: string;
    status: string;
    status_color: string;
    service_icon: string;
}

interface LoyaltyPoint {
    id: number;
    transaction_type: string;
    description: string;
    amount: number;
    created_at: string;
}

interface MemberProfile {
    id: number;
    member_number: string;
    first_name: string;
    last_name: string;
    full_name: string;
    membership_tier: string;
    tier_color: string;
    is_active: boolean;
    membership_start_date: string;
}

interface Stats {
    active_policies: number;
    pending_claims: number;
    loyalty_points: number;
    upcoming_appointments: number;
}

interface Props {
    stats: Stats;
    insurancePolicies: InsurancePolicy[];
    recentClaims: InsuranceClaim[];
    loyaltyPointsBalance: number;
    recentPointsTransactions: LoyaltyPoint[];
    upcomingAppointments: DentalAppointment[];
    memberProfile: MemberProfile | null;
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ 
    stats, 
    insurancePolicies, 
    recentClaims, 
    loyaltyPointsBalance, 
    recentPointsTransactions,
    upcomingAppointments,
    memberProfile 
}: Props) {
    return (
        <AppShell>
            <Head title="Member Dashboard" />
            
            <AppHeader breadcrumbs={breadcrumbs} />
            
            <AppContent className="p-6">
                <div className="space-y-6">
                {/* Welcome Header */}
                <div className="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white">
                    <div className="flex items-center justify-between">
                        <div>
                            <h1 className="text-2xl lg:text-3xl font-bold mb-2">
                                Welcome back, {memberProfile?.first_name || 'Member'}! 👋
                            </h1>
                            <p className="text-blue-100 text-lg">
                                Manage your insurance, track benefits, and access exclusive services
                            </p>
                            {memberProfile && (
                                <div className="flex items-center gap-3 mt-3">
                                    <Badge className={`bg-${memberProfile.tier_color}-100 text-${memberProfile.tier_color}-800 hover:bg-${memberProfile.tier_color}-200`}>
                                        {memberProfile.membership_tier.toUpperCase()} Member
                                    </Badge>
                                    <span className="text-blue-100 text-sm">
                                        Member #{memberProfile.member_number}
                                    </span>
                                </div>
                            )}
                        </div>
                        {!memberProfile && (
                            <Link href="/member/profile/create">
                                <Button className="bg-white/20 hover:bg-white/30 text-white border border-white/30">
                                    Complete Profile
                                </Button>
                            </Link>
                        )}
                    </div>
                </div>

                {/* Key Stats */}
                <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <Card className="hover:shadow-md transition-shadow">
                        <CardContent className="p-4">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm text-gray-600 mb-1">Active Policies</p>
                                    <p className="text-2xl font-bold text-gray-900">{stats.active_policies}</p>
                                </div>
                                <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span className="text-xl">🛡️</span>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="hover:shadow-md transition-shadow">
                        <CardContent className="p-4">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm text-gray-600 mb-1">Pending Claims</p>
                                    <p className="text-2xl font-bold text-gray-900">{stats.pending_claims}</p>
                                </div>
                                <div className="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <span className="text-xl">📋</span>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="hover:shadow-md transition-shadow">
                        <CardContent className="p-4">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm text-gray-600 mb-1">Loyalty Points</p>
                                    <p className="text-2xl font-bold text-gray-900">{loyaltyPointsBalance.toLocaleString()}</p>
                                </div>
                                <div className="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <span className="text-xl">⭐</span>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="hover:shadow-md transition-shadow">
                        <CardContent className="p-4">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm text-gray-600 mb-1">Appointments</p>
                                    <p className="text-2xl font-bold text-gray-900">{stats.upcoming_appointments}</p>
                                </div>
                                <div className="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <span className="text-xl">🦷</span>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <div className="grid lg:grid-cols-2 gap-6">
                    {/* Recent Insurance Policies */}
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-4">
                            <CardTitle className="text-lg font-semibold">Your Insurance Policies</CardTitle>
                            <Link href="/insurance/policies">
                                <Button variant="outline" size="sm">View All</Button>
                            </Link>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            {insurancePolicies.length > 0 ? (
                                insurancePolicies.slice(0, 3).map((policy) => (
                                    <div key={policy.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div className="flex-1">
                                            <div className="flex items-center gap-2 mb-1">
                                                <h4 className="font-medium text-gray-900">{policy.name}</h4>
                                                <Badge className={`text-xs ${
                                                    policy.status === 'active' ? 'bg-green-100 text-green-800' :
                                                    policy.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                    'bg-gray-100 text-gray-800'
                                                }`}>
                                                    {policy.status}
                                                </Badge>
                                            </div>
                                            <p className="text-sm text-gray-600">{policy.policy_number}</p>
                                            <p className="text-sm text-gray-500">Coverage: {policy.formatted_coverage}</p>
                                        </div>
                                        <Link href={`/insurance/policies/${policy.id}`}>
                                            <Button variant="ghost" size="sm">View</Button>
                                        </Link>
                                    </div>
                                ))
                            ) : (
                                <div className="text-center py-8 text-gray-500">
                                    <div className="text-4xl mb-2">🛡️</div>
                                    <p>No insurance policies yet</p>
                                    <p className="text-sm">Contact us to get started with protection</p>
                                </div>
                            )}
                        </CardContent>
                    </Card>

                    {/* Recent Claims */}
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-4">
                            <CardTitle className="text-lg font-semibold">Recent Claims</CardTitle>
                            <Link href="/insurance/claims">
                                <Button variant="outline" size="sm">View All</Button>
                            </Link>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            {recentClaims.length > 0 ? (
                                recentClaims.slice(0, 3).map((claim) => (
                                    <div key={claim.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div className="flex-1">
                                            <div className="flex items-center gap-2 mb-1">
                                                <h4 className="font-medium text-gray-900">{claim.title}</h4>
                                                <Badge className={`text-xs bg-${claim.status_color}-100 text-${claim.status_color}-800`}>
                                                    {claim.status.replace('_', ' ')}
                                                </Badge>
                                            </div>
                                            <p className="text-sm text-gray-600">{claim.claim_number}</p>
                                            <p className="text-sm text-gray-500">Amount: {claim.formatted_claimed_amount}</p>
                                        </div>
                                        <Link href={`/insurance/claims/${claim.id}`}>
                                            <Button variant="ghost" size="sm">View</Button>
                                        </Link>
                                    </div>
                                ))
                            ) : (
                                <div className="text-center py-8 text-gray-500">
                                    <div className="text-4xl mb-2">📋</div>
                                    <p>No claims submitted</p>
                                    <Link href="/insurance/claims/create">
                                        <Button className="mt-2" size="sm">Submit Claim</Button>
                                    </Link>
                                </div>
                            )}
                        </CardContent>
                    </Card>
                </div>

                <div className="grid lg:grid-cols-2 gap-6">
                    {/* Upcoming Appointments */}
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-4">
                            <CardTitle className="text-lg font-semibold">Upcoming Appointments</CardTitle>
                            <Link href="/dental/appointments">
                                <Button variant="outline" size="sm">View All</Button>
                            </Link>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            {upcomingAppointments.length > 0 ? (
                                upcomingAppointments.map((appointment) => (
                                    <div key={appointment.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div className="flex items-center gap-3 flex-1">
                                            <div className="text-2xl">{appointment.service_icon}</div>
                                            <div>
                                                <h4 className="font-medium text-gray-900 capitalize">{appointment.service_type}</h4>
                                                <p className="text-sm text-gray-600">{appointment.clinic_name}</p>
                                                <p className="text-sm text-gray-500">{appointment.formatted_date_time}</p>
                                            </div>
                                        </div>
                                        <Link href={`/dental/appointments/${appointment.id}`}>
                                            <Button variant="ghost" size="sm">View</Button>
                                        </Link>
                                    </div>
                                ))
                            ) : (
                                <div className="text-center py-8 text-gray-500">
                                    <div className="text-4xl mb-2">🦷</div>
                                    <p>No appointments scheduled</p>
                                    <Link href="/dental/appointments/create">
                                        <Button className="mt-2" size="sm">Book Appointment</Button>
                                    </Link>
                                </div>
                            )}
                        </CardContent>
                    </Card>

                    {/* Recent Loyalty Points */}
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-4">
                            <CardTitle className="text-lg font-semibold">Recent Points Activity</CardTitle>
                            <div className="text-right">
                                <p className="text-sm text-gray-600">Total Balance</p>
                                <p className="text-lg font-bold text-yellow-600">{loyaltyPointsBalance.toLocaleString()} pts</p>
                            </div>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            {recentPointsTransactions.length > 0 ? (
                                recentPointsTransactions.map((transaction) => (
                                    <div key={transaction.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div className="flex-1">
                                            <h4 className="font-medium text-gray-900">{transaction.description}</h4>
                                            <p className="text-sm text-gray-500 capitalize">{transaction.transaction_type}</p>
                                        </div>
                                        <div className={`font-semibold ${transaction.amount > 0 ? 'text-green-600' : 'text-red-600'}`}>
                                            {transaction.amount > 0 ? '+' : ''}{transaction.amount} pts
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <div className="text-center py-8 text-gray-500">
                                    <div className="text-4xl mb-2">⭐</div>
                                    <p>Start earning points!</p>
                                    <p className="text-sm">Purchase policies and refer friends to earn rewards</p>
                                </div>
                            )}
                        </CardContent>
                    </Card>
                </div>

                {/* Quick Actions */}
                <Card>
                    <CardHeader>
                        <CardTitle className="text-lg font-semibold">Quick Actions</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
                            <Link href="/insurance/claims/create">
                                <Button className="w-full h-20 flex flex-col items-center gap-2 bg-blue-600 hover:bg-blue-700">
                                    <span className="text-2xl">📋</span>
                                    <span className="text-sm">Submit Claim</span>
                                </Button>
                            </Link>
                            
                            <Link href="/dental/appointments/create">
                                <Button className="w-full h-20 flex flex-col items-center gap-2 bg-green-600 hover:bg-green-700">
                                    <span className="text-2xl">🦷</span>
                                    <span className="text-sm">Book Appointment</span>
                                </Button>
                            </Link>
                            
                            <Link href="/lifestyle/products">
                                <Button className="w-full h-20 flex flex-col items-center gap-2 bg-purple-600 hover:bg-purple-700">
                                    <span className="text-2xl">🛍️</span>
                                    <span className="text-sm">Lifestyle Products</span>
                                </Button>
                            </Link>
                            
                            <Link href="/member/profile/edit">
                                <Button className="w-full h-20 flex flex-col items-center gap-2 bg-orange-600 hover:bg-orange-700">
                                    <span className="text-2xl">👤</span>
                                    <span className="text-sm">Update Profile</span>
                                </Button>
                            </Link>
                        </div>
                    </CardContent>
                </Card>
                </div>
            </AppContent>
        </AppShell>
    );
}